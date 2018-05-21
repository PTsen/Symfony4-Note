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

/**
* Class for Category API REST
*/

class ApiCategorie extends Controller
{
    
    /**
    * Function that get all categories from database
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
    *Function that create a category
    * #param Request, category that need to be created
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

                $response = new JsonResponse(array(
                    'status'=>'500',
                    'message'=>'Content is not valid'));
            }

            $response->headers->set('Content-Type', 'application/json');
            $response->headers->set('Access-Control-Allow-Origin', '*');
            $response->headers->set("Access-Control-Allow-Methods", "GET,PUT,POST,DELETE,OPTIONS");
            $response->headers->set("Access-Control-Allow-Headers", 'Content-Type',true);
            $response->setContent("Done");
            return $response;
    }

    
    /**
    * Function that delete a category whit his id
    * #param id, the id
    * @Route("/api/categorie/delete/{id}", name="api_categorie_delete")
    * @Method("DELETE")
    */
    public function delet_(Request $request, $id)
    {

        

            $data = $request->getContent();
            $elem = json_decode($data,true);
            $entityManager = $this->getDoctrine()->getManager();
            $em = $entityManager-> getRepository (Categorie::class)->find($id);
            try {
                $entityManager->remove($em);
                $entityManager->flush();
            }catch (\Exception $ex){

                $response = new JsonResponse(array(
                    'status'=>'500',
                    'message'=>'Content is not valid'));
		
            }
            $response = new JsonResponse();
            $response->headers->set('Content-Type', 'application/json');
            $response->headers->set('Access-Control-Allow-Origin', '*');
            $response->headers->set("Access-Control-Allow-Methods", "GET,PUT,POST,DELETE,OPTIONS");
            $response->setContent("Done");       
			return $response;
        
    }


    /**
    * Function that update a category
    * #param, Request the category and new data 
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
					$response = new JsonResponse(array(
                    'status'=>'500',
                    'message'=>'Content is not valid'));       
        }
		
		    $response = new Response();
            $response->headers->set('Content-Type', 'application/json');
            $response->headers->set('Access-Control-Allow-Origin', '*');
            $response->headers->set("Access-Control-Allow-Methods", "GET,PUT,POST,DELETE,OPTIONS");
            $response->headers->set("Access-Control-Allow-Headers", 'Content-Type',true);
            $response->setContent("Done");
            return $response;

    }
}


