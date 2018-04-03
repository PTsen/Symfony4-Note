<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Note;
use App\Entity\Categorie;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class NoteController extends Controller
{
    /**
     * @Route("/addnote", name="addnote")
     */
    public function add(Request $request)
    {

        $note = new Note();
        $form = $this->createFormBuilder($note)
                ->add('title',TextType::class,array('label'=>'Title')) //zone de text pour écrire
                ->add('note',TextType::class,array('label'=>'Note '))
                ->add('date',DateType::class,array('label'=>'Due Date ')) // liste déroulante pour save date
                ->add('categorie',EntityType::class,array(
                    'class' => Categorie::class,
                    'choice_label' => 'categorie',
                ))
                ->add('save',SubmitType::class,array('label'=>'Save')) // bouton de soummision de forme
                ->getForm();
        $form->handleRequest ($request);
        $note = $form->getData();



        

        if ($form->isSubmitted() && $form->isValid()) {

            $em=$this->getDoctrine()->getManager();
            $em->persist($note);
            $em->flush();
            return $this->redirectToRoute('notes');

        }
       
       
        return $this->render('noteView.html.twig',array('forms'=>$form->createView())) ;     
    }


    /**
     * @Route("/notes", name="notes")
     */
    public function select()
    {

        $em = $this -> getDoctrine() 
        -> getRepository (Note::class)->findall();
       
        return $this->render('listNotes.html.twig',array('notes'=>$em)) ; 
        
    }


      /**
     * @Route("/delNote", name="delNotes")
     */
    public function delet_(Request $request)
    {

        $id = $request ->query->get('id_');
        $entityManager = $this->getDoctrine()->getManager();
        $em = $entityManager-> getRepository (Note::class)->find($id);
        try {
        $entityManager->remove($em);
        $entityManager->flush();
        }catch (\Exception $ex){

        return $this->render('sqlError.html.twig',array('name'=>"Error cannot delet Note")) ; 

        }
        return $this->redirectToRoute('notes');

        
    }

  /**
     * @Route("/updateNote", name="updateNote")
     */
    public function update_(Request $request)
    {

        $id = $request ->query->get('id_');
        $entityManager = $this->getDoctrine()->getManager();
        $em = $entityManager-> getRepository (Note::class)->find($id);
        $form = $this->createFormBuilder($em)
        ->add('title',TextType::class,array('label'=>'Title ')) //zone de text pour écrire
        ->add('note',TextType::class,array('label'=>'Note '))
        ->add('date',DateType::class,array('label'=>'Due Date ')) // liste déroulante pour save date
        ->add('categorie',EntityType::class,array(
            'class' => Categorie::class,
            'choice_label' => 'categorie',
        ))
        ->add('save',SubmitType::class,array('label'=>'Save ')) // bouton de soummision de forme
        ->getForm();
$form->handleRequest ($request);

if ($form->isSubmitted() && $form->isValid()) {
    $entityManager->flush();
    return $this->redirectToRoute('notes');

}


return $this->render('noteView.html.twig',array('forms'=>$form->createView())) ;     
        
    }


}