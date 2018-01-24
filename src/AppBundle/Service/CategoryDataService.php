<?php

namespace AppBundle\Service;

class CategoryDataService
{
    private $categoriesPath;
    private $categories;

    function __construct() {
        $this->categoriesPath = realpath('../var') . '/data/newsletter/categories.json';
        $this->directoryCheck();
        $this->categories = json_decode(file_get_contents($this->categoriesPath));
    }

    public function directoryCheck()
    {
        if(!file_exists($this->categoriesPath)){
            $path = realpath('../var') . '/data/newsletter';
            if(!file_exists($path))
            {
                mkdir($path, 0777, true); 
            }
            $defaultCategories = ["Bicycles","Motorcycles","Tourism","Enduro","MTB"];
            file_put_contents($this->categoriesPath, json_encode($defaultCategories));
        }
    }

    public function getCategories()
    {
        $categories = (array)$this->categories;
        return array_combine(range(1, count($categories)), array_values($categories));
    }

}