<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use \DateTime;

use App\Entity\Note;
use App\Entity\Categorie;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\HttpFoundation\JsonResponse;
/*
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
*/

use Symfony\Component\DomCrawler\Crawler;


class ApiNoteAngular extends Controller
{
    
    /**
     * @Route("/apiAngular/note/list", name="apiAngular_note_list")
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


        }else{

            $em = $this -> getDoctrine() 
            -> getRepository (Note::class)->findall();

            /*
            $encoder = array(new JsonEncoder());
            $normalizers= array(new ObjectNormalizer());
            $serializer = new Serializer ($normalizers,$encoder);
            $data =  $serializer->serialize($em, 'json');
            */

            $data = $this->get('serializer')->serialize($em, 'json');


            $response = new JsonResponse();
            $response->headers->set('Content-Type', 'application/json');
            $response->headers->set('Access-Control-Allow-Origin', '*');
            $response->headers->set("Access-Control-Allow-Methods", "GET,PUT,POST,DELETE,OPTIONS");

        
            $response->setContent($data);
        }
        return $response;
        
    }


        
    /**
     * @Route("/apiAngular/note/get/{id}", name="apiAngular_note_get")
     * @Method({"GET","OPTIONS"})
     */
    public function getById(Request $request,$id)
    {

        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS'){

            $response = new Response();

            $response->headers->set('Content-Type', 'application/json');
            $response->headers->set('Access-Control-Allow-Origin', '*');
            $response->headers->set("Access-Control-Allow-Methods", "GET,PUT,POST,DELETE,OPTIONS");
            $response->headers->set("Access-Control-Allow-Headers", 'Content-Type',true);


        }else{

            $em = $this -> getDoctrine() 
            -> getRepository (Note::class)->find($id);

            /*
            $encoder = array(new JsonEncoder());
            $normalizers= array(new ObjectNormalizer());
            $serializer = new Serializer ($normalizers,$encoder);
            $data =  $serializer->serialize($em, 'json');
            */

            $data = $this->get('serializer')->serialize($em, 'json');


            $response = new JsonResponse();
            $response->headers->set('Content-Type', 'application/json');
            $response->headers->set('Access-Control-Allow-Origin', '*');
            $response->headers->set("Access-Control-Allow-Methods", "GET,PUT,POST,DELETE,OPTIONS");

        
            $response->setContent($data);
        }
        return $response;
        
    }

 /**
     * @Route("/apiAngular/note/create", name="apiAngular_note_create")
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
            $elem = json_decode($data,true);
            $note=new Note();

            $cate = $this -> getDoctrine()
            -> getRepository (Categorie::class)->find($elem['categorie']);

            $note->setCategorie($cate);
            $date =  new DateTime($elem['date']);
            $note->setDate($date);
            $note->setNote($elem['note']);
            $note->setTitle($elem['title']);
            $em=$this->getDoctrine()->getManager();

            try{
                $em->persist($note);
                $em->flush();
            }catch(\Exception $ex){

                $response = new JsonResponse(array(
                    'status'=>'500',
                    'message'=>'Content is not valid'));
                    return $response;            }
        }
        return $response;
    }

    
    /**
     * @Route("/apiAngular/note/delete/{id}", name="apiAngular_note_delete")
     * @Method({"DELETE","OPTIONS"})
     */
    public function delet_(Request $request,$id)
    {
		
		 if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS'){

            $response = new Response();

            $response->headers->set('Content-Type', 'application/json');
            $response->headers->set('Access-Control-Allow-Origin', '*');
            $response->headers->set("Access-Control-Allow-Methods", "GET,PUT,POST,DELETE,OPTIONS");
            $response->headers->set("Access-Control-Allow-Headers", 'Content-Type',true);
			
			return $response;

        }else{
			
			$data = $request->getContent();
			$elem = json_decode($data,true);
			
			$entityManager = $this->getDoctrine()->getManager();
			$em = $entityManager-> getRepository (Note::class)->find($id);
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
     * @Route("/apiAngular/note/put", name="apiAngular_note_put")
     *  @Method({"PUT","OPTIONS"})
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
            $entityManager = $this->getDoctrine()->getManager();
            
            try {

                $note = $entityManager-> getRepository (Note::class)->find($elem['id']);
                $note->setTitle($elem['title']);

                if(isset($elem['categorie'])){
                    $cate = $this -> getDoctrine()
                    -> getRepository (Categorie::class)->find($elem['categorie']);
                    $note->setCategorie($cate);
                }

                $date =  new DateTime($elem['date']);
                $note->setDate($date);

                $note->setNote($elem['note']);
                $entityManager->flush();
            
            }catch (\Exception $ex){

                $response = new JsonResponse(array(
                    'status'=>'500',
                    'message'=>'Content is not valid'));
                    return $response;
            }            

            $response = new Response();
            $response->headers->set('Content-Type', 'application/json');
            $response->headers->set('Access-Control-Allow-Origin', '*');
            $response->headers->set("Access-Control-Allow-Methods", "GET,PUT,POST,DELETE,OPTIONS");
            $response->headers->set("Access-Control-Allow-Headers", 'Content-Type',true);

        }
 
        return $response;

    }

     /**
     * @Route("/apiAngular/note/search", name="apiAngular_note_search")
     * @Method({"POST","OPTIONS"})
     */
    public function search_(Request $request)
    {

        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS'){

            $response = new Response();
            $response->headers->set('Content-Type', 'application/json');
            $response->headers->set('Access-Control-Allow-Origin', '*');
            $response->headers->set("Access-Control-Allow-Methods", "GET,PUT,POST,DELETE,OPTIONS");
            $response->headers->set("Access-Control-Allow-Headers", 'Content-Type',true);
			
        }else{
            $tag = $request->getContent();
            
            /*
            $entityManager = $this->getDoctrine()->getManager();
            $em = $entityManager-> getRepository (Note::class)->findall();
            $tab = array();

                foreach($em as $note) { 
                
                    $xmlCrawler = new Crawler();
                    $xmlCrawler->addXmlContent($note->getNote());
                    $txt=" ";

                    try {
        
                        if( $xmlCrawler->filterXPath('//note/tag')->count()){
                            $txt = $xmlCrawler->filterXPath('//note/tag')->text();
                        }

                    }catch (\Exception $ex){
                        $response = new JsonResponse(array(
                            'status'=>'500',
                            'message'=>'Content is not valid'));
                            return $response;                    }
        
                    if ($txt == $tag){
                        array_push($tab, $note);   
                    }       

                }
*/
        }
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set("Access-Control-Allow-Methods", "GET,PUT,POST,DELETE,OPTIONS");
        $response->headers->set("Access-Control-Allow-Headers", 'Content-Type',true);
        $response->setContent($tag);
        return $response;
    }
}


