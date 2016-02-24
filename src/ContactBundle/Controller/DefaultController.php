<?php

namespace ContactBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use ContactBundle\Entity\Contact;
use ContactBundle\Form\ContactType;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DefaultController extends Controller
{
    public function viewAction() {
		
		$em = $this->getDoctrine()->getManager();
		
		$user = $this->getUser();
		// $advert est donc une instance de OC\PlatformBundle\Entity\Advert
		// ou null si l'id $id  n'existe pas, d'où ce if :
		/*if (null === $user->getId()) {
		  throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
		}*/
		$contacts = $em->getRepository('ContactBundle:Contact')->findBy(array('user' => $user));		
		return $this->render('ContactBundle:Default:index.html.twig', array('contacts' => $contacts));
	}
	
	public function addAction(Request $request) {
		$contact = new Contact($this->getUser());

		
		// Pour l'instant, pas de candidatures, catégories, etc., on les gérera plus tard

		// À partir du formBuilder, on génère le formulaire
		$form = $this->createForm(ContactType::class,$contact);
				
		if ($form->handleRequest($request)->isValid()) {
		  $em = $this->getDoctrine()->getManager();
		  $em->persist($contact);
		  $em->flush();

		  $request->getSession()->getFlashBag()->add('notice', 'Contact bien enregistrée.');		  
		  // On redirige vers la page de visualisation de l'annonce nouvellement créée
		  return $this->redirect($this->generateUrl('contact_homepage'));
		}
		
		return $this->render('ContactBundle:Default:add.html.twig', array('form' => $form->createView(),));
	}
	
	public function deleteAction($id)
	{
		$em = $this->getDoctrine()->getManager();
		
		$contact = $em->getRepository('ContactBundle:Contact')->find($id);
		
		if (null === $contact) {
		  throw new NotFoundHttpException("Le contact d'id ".$contact." n'existe pas.");
		}
		
		$em->remove($contact);
		$em->flush();	

		return $this->redirect($this->generateUrl('contact_homepage'));
	}
	
	public function editAction($id, Request $request) {
		$em = $this->getDoctrine()->getManager();
		
		$contact = $em->getRepository('ContactBundle:Contact')->find($id);
			
		// À partir du formBuilder, on génère le formulaire
		$form = $this->createForm(ContactType::class,$contact);
		if ($form->handleRequest($request)->isValid()) {
		  $em->persist($contact);
		  $em->flush();
		  
		  // On redirige vers la page de visualisation de l'annonce nouvellement créée
		  return $this->redirect($this->generateUrl('contact_homepage'));
		}		
		return $this->render('ContactBundle:Default:add.html.twig', array('form' => $form->createView()));
	}
}