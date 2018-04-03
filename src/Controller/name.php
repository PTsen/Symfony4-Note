<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\Task;
use App\Entity\Categorie;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;





class name extends Controller
{
    /**
     * @Route ("/name")
     */
    public function name()
    {
        $name = "Sen";
        return $this->render('affiche.html.twig',array('name'=>$name)) ;     
    }

     /**
     * @Route ("/formulaire")
     */
    public function formulaire(Request $request)
    {
        $task = new Task();

        $catego= new Categorie("1");
        $categ= new Categorie("2");
        $cate=new Categorie("3");

        
        $listCat=array ($catego,$categ,$cate);

        //Creation du formulaire
        $form = $this->createFormBuilder($task)
                ->add('task',TextType::class,array('label'=>'Tache')) //zone de text pour écrire
                ->add('dueDate',DateType::class,array('label'=>'A faire ')) // liste déroulante pour save date
                ->add('save',SubmitType::class,array('label'=>'Save')) // bouton de soummision de forme
                ->getForm();


 


        // une fois form soumis et en ordre (chaque champs remplis)
        if ($form->isSubmitted() && $form->isValid()) {

            var_dump($task->getDueDate());
            die();
       }
          
/* 
            $em=$this->getDoctrine()->getManager();
            $em->persist($task);
            $em->flush();
            return new Response ("ok");
        }
*/
        return $this->render('noteView.html.twig',array('forms'=>$form->createView())) ;     
    }
}

?>