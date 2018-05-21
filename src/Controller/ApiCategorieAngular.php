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
* Class for Category API REST in Angular
*/

class ApiCategorieAngular extends Controller
{
    
    /**
    * Function that get all categories from database
    * @Route("/apiAngular/categorie/list", name="apiAngular_categorie_list")
    * @Method({"GET","OPTIONS"})
    */
    public function select(Request $request)
    {

        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS'){

            $response = new Response();

            $response->headers->set('Content-Type', 'application/json');
            $response->headers->set('Access-Control-Allow-Origin', '*');
            $response->headers->set("Access-Control-Allow-Methods", "GET,PUT,POST,DELETE,OPTIONS");
            $response->headers->set("Access-Control-Allow-Headers", 'Content-Type',true);

        }else {

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
       
        }
        
        return $response;
        
    }

    /**
    * Function that create a category
    * #param Request, category that need to be created
    * @Route("/apiAngular/categorie/create", name="apiAngular_categorie_create")
    * @Method({"POST","OPTIONS"})
    */
    public function create(Request $request)
    {

        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS'){

            $response = new Response();
            $response->headers->set('Content-Type', 'application/json');
            $response->headers->set('Access-Control-Allow-Origin', '*');
            $response->headers->set("Access-Control-Allow-Methods", "GET,PUT,POST,DELETE,OPTIONS");
            $response->headers->set("Access-Control-Allow-Headers", 'Content-Type',true);
			
        }else{

            $data = $request->getContent();
            $cat=new Categorie();
            $cat->setCategorie($data);
            $em=$this->getDoctrine()->getManager();

            try{

                $em->persist($cat);
                $em->flush();

            }catch(\Exception $ex){

                $response = new JsonResponse(array(
                    'status'=>'500',
                    'message'=>'Content is not valid'));
            }

            $response = new Response();
            $response->headers->set('Content-Type', 'application/json');
            $response->headers->set('Access-Control-Allow-Origin', '*');
            $response->headers->set("Access-Control-Allow-Methods", "GET,PUT,POST,DELETE,OPTIONS");
            $response->headers->set("Access-Control-Allow-Headers", 'Content-Type',true);
            $response->setContent($data);

        }

        return $response;
    }

    
    /**
    * Function that delete a category whit his id
    * #param id, the id
    * @Route("/apiAngular/categorie/delete/{id}", name="apiAngular_categorie_delete")
    * @Method({"DELETE","OPTIONS"})
    */
    public function delet_(Request $request, $id)
    {

        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS'){

            $response = new Response();
            $response->headers->set('Content-Type', 'application/json');
            $response->headers->set('Access-Control-Allow-Origin', '*');
            $response->headers->set("Access-Control-Allow-Methods", "GET,PUT,POST,DELETE,OPTIONS");
            $response->headers->set("Access-Control-Allow-Headers", 'Content-Type',true);
			

        }else{

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
        }
			return $response;
        
    }


    /**
    * Function that update a category
    * #param, Request the category and new data 
    * @Route("/apiAngular/categorie/put", name="apiAngular_categorie_put")
    * @Method({"PUT","OPTIONS"})
    */
    public function update_(Request $request)
    {
		
		if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS'){

            $response = new Response();
            $response->headers->set('Content-Type', 'application/json');
            $response->headers->set('Access-Control-Allow-Origin', '*');
            $response->headers->set("Access-Control-Allow-Methods", "GET,PUT,POST,DELETE,OPTIONS");
            $response->headers->set("Access-Control-Allow-Headers", 'Content-Type',true);
			
        }else{

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

		}
            return $response;
    }
}


