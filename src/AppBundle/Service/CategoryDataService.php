<?php

namespace AppBundle\Service;

use AppBundle\Entity\User;

class CategoryDataService
{
    private $categoriesPath;
    private $categories;

    function __construct() {
        $this->categoriesPath = realpath('../var/data/newsletter/categories.json');
        $this->categories = json_decode(file_get_contents($this->categoriesPath));
    }

    public function getCategories()
    {
        return (array)$this->categories;
    }

    public function getCategoryNames($keys)
    {
        foreach ($keys as $value) {
            
        }
    }

}