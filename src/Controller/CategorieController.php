<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\Categorie;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class CategorieController extends Controller
{
    /**
     * @Route("/addcategorie", name="addcategorie")
     */
    public function addCategorie(Request $request)
    {

        $cate = new Categorie ();

        $form = $this->createFormBuilder($cate)
        ->add('categorie',TextType::class,array('label'=>'Categorie')) //zone de text pour écrire
        ->add('save',SubmitType::class,array('label'=>'Save')) // bouton de soummision de forme
        ->getForm();

        $form->handleRequest ($request);
        $cate = $form->getData();


        if ($form->isSubmitted() && $form->isValid()) {

            $em=$this->getDoctrine()->getManager();
            $em->persist($cate);
            $em->flush();
            return $this->redirectToRoute('categories');
       }

        return $this->render('categorieView.html.twig',array('forms'=>$form->createView()));
    }


    /**
     * @Route("/categories", name="categories")
     */
    public function select(Request $request)
    {

        $em = $this -> getDoctrine() 
        -> getRepository (Categorie::class)->findall();
       
        return $this->render('listCategories.html.twig',array('categories'=>$em)) ; 
        
    }
    
    /**
     * @Route("/delCat", name="delCat")
     */
    public function delet_(Request $request)
    {

        $id = $request ->query->get('id_');
        $entityManager = $this->getDoctrine()->getManager();
        $em = $entityManager-> getRepository (Categorie::class)->find($id);
        try {
        $entityManager->remove($em);
        $entityManager->flush();
        }catch (\Exception $ex){

        return $this->render('sqlError.html.twig',array('name'=>"Error cannot delet category")) ; 

        }
        return $this->redirectToRoute('categories');

        
    }


      /**
     * @Route("/updateCat", name="updateCat")
     */
    public function update_(Request $request)
    {

        $id = $request ->query->get('id-');
        $entityManager = $this->getDoctrine()->getManager();
        $em = $entityManager-> getRepository (Categorie::class)->find($id);
        $form = $this->createFormBuilder($em)
        ->add('categorie',TextType::class,array('label'=>'Categorie ')) //zone de text pour écrire
        ->add('save',SubmitType::class,array('label'=>'Save')) // bouton de soummision de forme
        ->getForm();
$form->handleRequest ($request);

if ($form->isSubmitted() && $form->isValid()) {
    $entityManager->flush();
    return $this->redirectToRoute('categories');

}
return $this->render('categorieView.html.twig',array('forms'=>$form->createView()));


    }
}


