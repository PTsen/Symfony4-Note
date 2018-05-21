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


/**
 * Class for Note API REST in Angular
 */
class ApiNoteAngular extends Controller
{
    
    /**
    * Function that get all notes from database
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
    * Function that query a note with his id
    * #param id, the id
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
    * Function that create a note 
    * #param Request, note that need to be created
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
     * Function that delete a note whit his id
     * #param id, the id
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
     * Function that update a note
     * #param, Request the note and new data 
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
                
                $note->setNote($elem['note']);
                $entityManager->flush();


                if(isset($elem['categorie'])){
                    $cate = $this -> getDoctrine()
                    -> getRepository (Categorie::class)->find($elem['categorie']);
                    $note->setCategorie($cate);
                }

                $date =  new DateTime($elem['date']);
                $note->setDate($date);

                $entityManager->flush();
            }catch (\Exception $ex){

                $response = new JsonResponse(array(
                    'status'=>'500',
                    'message'=>$ex));

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

}


