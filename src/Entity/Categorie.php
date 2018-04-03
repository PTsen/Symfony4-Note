<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategorieRepository")
 */
class Categorie
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $cate;


    function __constructeur(){
        $this->cate ="text";

    }

    public function getCategorie(){
        return $this->cate;
    }

    public function setCategorie($cat){
        $this->cate=$cat;
    }

    public function getId(){

        return $this->id;

    }
}
