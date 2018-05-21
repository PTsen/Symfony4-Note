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



class ApiNote extends Controller
{
    
    /**
     * @Route("/api/note/list", name="api_note_list")
     * @Method("GET")
     */
    public function select(Request $request)
    {

            $em = $this -> getDoctrine() 
            -> getRepository (Note::class)->findall();
            $data = $this->get('serializer')->serialize($em, 'json');
            $response = new JsonResponse();
            $response->headers->set('Content-Type', 'application/json');
            $response->headers->set('Access-Control-Allow-Origin', '*');
            $response->headers->set("Access-Control-Allow-Methods", "GET,PUT,POST,DELETE,OPTIONS");       
            $response->setContent($data);
            return $response;
        
    }


 /**
     * @Route("/api/note/create", name="api_note_create")
     * @Method("POST")
     */
    public function create(Request $request)
    {

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
        }

        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set("Access-Control-Allow-Methods", "GET,PUT,POST,DELETE,OPTIONS");
        $response->headers->set("Access-Control-Allow-Headers", 'Content-Type',true);
        $response->setContent("Done");
        return $response;
    }

    
    /**
     * @Route("/api/note/delete/{id}", name="api_note_delete")
     * @Method("DELETE")
     */
    public function delet_(Request $request,$id)
    {
		
			
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
            $response->setContent("Done");
		    return $response;

        
    }


      /**
     * @Route("/api/note/put", name="api_note_put")
     * @Method("PUT")
     */
    public function update_(Request $request)
    {
        $data = $request->getContent();
        $elem = json_decode($data,true);
        $id = $elem['id'];
        $entityManager = $this->getDoctrine()->getManager();

        try {

            $note = $entityManager-> getRepository (Note::class)->find($id);

            if(isset($elem['categorie'])){
            $cate = $this -> getDoctrine()
            -> getRepository (Categorie::class)->find($elem['categorie']);
            $note->setCategorie($cate);
            }
            if(isset($elem['date'])){
            $date =  new DateTime($elem['date']);
            $note->setDate($date);
            }
            if(isset($elem['note'])){
            $note->setNote($elem['note']);
            }
            if(isset($elem['title'])){
            $note->setTitle($elem['title']);
            }
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

}


