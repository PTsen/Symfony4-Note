<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\Categorie;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class ApiCategorie extends Controller
{
    
    /**
     * @Route("/api/categorie/list", name="api_categorie_list")
     * @Method("GET")
     */
    public function select(Request $request)
    {

        $em = $this -> getDoctrine() 
        -> getRepository (Categorie::class)->findall();
        $encoder = array(new JsonEncoder());
        $normalizers= array(new ObjectNormalizer());
        $serializer = new Serializer ($normalizers,$encoder);

        $data =  $serializer->serialize($em, 'json');
        
        $response = new JsonResponse();
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set("Access-Control-Allow-Methods", "GET,PUT,POST,DELETE,OPTIONS");
        
        $response->setContent($data);

        return $response;
        
    }

 /**
     * @Route("/api/categorie/create", name="api_categorie_create")
     * @Method("POST")
     */
    public function create(Request $request)
    {


        $data = $request->getContent();
        $elem = json_decode($data,true);
        $cat=new Categorie();
        $cat->setCategorie($elem['categorie']);
        $em=$this->getDoctrine()->getManager();

        try{
        $em->persist($cat);
        $em->flush();
        }catch(\Exception $ex){

            return $this->render('sqlError.html.twig',array('name'=>$ex)) ; 
        }
        return $this->redirectToRoute('categories');
    }

    
    /**
     * @Route("/api/categorie/delete", name="api_categorie_delete")
     * @Method("DELETE")
     */
    public function delet_(Request $request)
    {
        $data = $request->getContent();
        $elem = json_decode($data,true);
        $id = $elem['id'];
        $entityManager = $this->getDoctrine()->getManager();
        $em = $entityManager-> getRepository (Categorie::class)->find($id);
        try {
        $entityManager->remove($em);
        $entityManager->flush();
        }catch (\Exception $ex){

        return $this->render('sqlError.html.twig',array('name'=>$ex)) ; 

        }
        return $this->redirectToRoute('categories');

        
    }


      /**
     * @Route("/api/categorie/put", name="api_categorie_put")
     * @Method("PUT")
     */
    public function update_(Request $request)
    {
        $data = $request->getContent();
        $elem = json_decode($data,true);
        $id = $elem['id'];
        $entityManager = $this->getDoctrine()->getManager();
        try {

            $em = $entityManager-> getRepository (Categorie::class)->find($id);
            $em->setCategorie($elem['categorie']);
            $entityManager->flush();
            
        }catch (\Exception $ex){
            return $this->render('sqlError.html.twig',array('name'=>$ex)) ; 
            }
 
            return $this->redirectToRoute('categories');

    }
}


