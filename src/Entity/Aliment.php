<?php

namespace App\Entity;

use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\ImageTrait;
use App\Entity\Traits\Timestampable;
use App\Repository\AlimentRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=AlimentRepository::class)
 * @ORM\HasLifecycleCallbacks()
 * @Vich\Uploadable
 * @ApiResource(
 *  normalizationContext={"groups"={"aliment:read"}}
 * )
 */

class Aliment
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"aliment:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"aliment:read"})
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"aliment:read"})
     */
    private $description;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"aliment:read:full"})
     */
    private $content;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"aliment:read:full"})
     */
    private $info;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="aliments")
     * @Groups({"aliment:read"})
     */
    private $user;

    /**
     * @ORM\ManyToMany(targetEntity=Category::class, inversedBy="aliments")
     */
    private $categories;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\Range(
     *      min = 0,
     *      max = 100,
     * )
     */
    private $proteines;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\Range(
     *      min = 0,
     *      max = 100,
     * )
     */
    private $lipides;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\Range(
     *      min = 0,
     *      max = 100,
     * )
     */
    private $glucides;

    /**
     * @ORM\ManyToMany(targetEntity=Recette::class, mappedBy="ingredients")
     */
    private $recettes;

    use Timestampable; 
    
    use ImageTrait; 

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->recettes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getInfo(): ?string
    {
        return $this->info;
    }

    public function setInfo(string $info): self
    {
        $this->info = $info;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|Category[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        $this->categories->removeElement($category);

        return $this;
    }

    public function getProteines(): ?int
    {
        return $this->proteines;
    }

    public function setProteines(?int $proteines): self
    {
        $this->proteines = $proteines;

        return $this;
    }

    public function getLipides(): ?int
    {
        return $this->lipides;
    }

    public function setLipides(?int $lipides): self
    {
        $this->lipides = $lipides;

        return $this;
    }

    public function getGlucides(): ?int
    {
        return $this->glucides;
    }

    public function setGlucides(?int $glucides): self
    {
        $this->glucides = $glucides;

        return $this;
    }

    public function getEnergie(): ?int
    {
        $energie = $this->getProteines()*4+$this->getLipides()*9+$this->getProteines()*9;
        return  $energie;
    }

    /**
     * @return Collection|Recette[]
     */
    public function getRecettes(): Collection
    {
        return $this->recettes;
    }

    public function addRecette(Recette $recette): self
    {
        if (!$this->recettes->contains($recette)) {
            $this->recettes[] = $recette;
            $recette->addIngredient($this);
        }

        return $this;
    }

    public function removeRecette(Recette $recette): self
    {
        if ($this->recettes->removeElement($recette)) {
            $recette->removeIngredient($this);
        }

        return $this;
    }
}
