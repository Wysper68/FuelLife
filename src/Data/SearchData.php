<?php

namespace App\Data;

class SearchData{
    /**
     * @var string
     */
    public $q = '';

    /**
     * @var Category[]
     */
    public $categories = [];

    /**
     * @var int
     */
    public $page = 1;


}