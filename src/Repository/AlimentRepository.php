<?php

namespace App\Repository;

use App\Entity\Aliment;
use App\Data\SearchData;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @method Aliment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Aliment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Aliment[]    findAll()
 * @method Aliment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AlimentRepository extends ServiceEntityRepository
{
    private $paginator;

    public function __construct(ManagerRegistry $registry, PaginatorInterface $paginator)
    {
        parent::__construct($registry, Aliment::class);
        $this->paginator = $paginator;
    }

    /**
     * Recupere les produits en lien avec une recherche
     * @return PaginationInterface
     */
    public function findSearch(SearchData $search) : PaginationInterface 
    {
        // automatically knows to select Products
        // the "p" is an alias you'll use in the rest of the query
        $q = $this
                ->createQueryBuilder('a')
                ->orderBy('a.createdAt', 'DESC');

        if(!empty($search->q)){
            $q = $q
                ->andWhere('a.name LIKE :q')
                ->setParameter('q', "%{$search->q}%");
        }

        if(!empty($search->categories)){
            $q = $q
                ->innerJoin('a.categories', 'c')
                ->andWhere('c.id IN (:categories)')
                ->setParameter('categories', $search->categories);
        }

        $query = $q->getQuery();
        return $this->paginator->paginate(
            $query, // Requête contenant les données à paginer (ici nos articles)
            $search->page, // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            3 // Nombre de résultats par page
        );
    }

    // /**
    //  * @return Aliment[] Returns an array of Aliment objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Aliment
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}


