<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use App\Entity\Categorie;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NoteRepository")
 *  @UniqueEntity(
 * fields={"title"},
 * errorPath = "title",
 * message = "existing title")
 */
class Note
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
    private $note;
    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="string")
     */
    private $title;

    /**
     * 
     * @ORM\ManyToOne(targetEntity = "Categorie")
     */
    private $categorie;

    public function getNote(){
        return $this->note;
    }

    public function setNote($note){
        $this->note=$note;
    }


    public function getDate(){

        return $this->date;

    }

    public function getTitle(){

        return $this->title;

    }


    public function setDate($date){

        $this->date=$date;

    }

    public function setTitle($title){

        $this->title=$title;

    }

    public function getCategorie(){

        return $this->categorie;

    }

    public function setCategorie($cat){

         $this->categorie = $cat;

    }



    public function getId(){

        return $this->id;

    }
       


}
