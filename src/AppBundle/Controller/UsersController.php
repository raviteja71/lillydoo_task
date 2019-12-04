<?php

namespace AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Form\UsersCollection;
use AppBundle\Entity\Users;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;

class UsersController extends Controller
{
    /**
     * Matches /users exactly
     *
     * @Route("/users", name="Users")
     */
    public function listAction(Request $request)
    {
		// 1) build the form
        $adBook = new Users();
        $form = $this->createForm(UsersCollection::class, $adBook);

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
			$data = $form->getData();
            // 4) save the Users!
            $entityManager = $this->getDoctrine()->getManager();

			$directory = $this->getParameter('image_directory');
			$file = $form['picture']->getData();
			if(!empty($file)){
				$NewFilename = $file->getClientOriginalName();
	    			$file->move($directory, $NewFilename);
				$adBook->setPictureurl($NewFilename);
			} else {
				$adBook->setPictureurl("Not Available");
			}
			$adBook->setFirstname($data->getFirstName());
			$adBook->setLastname($data->getLastName());
			$adBook->setEmail($data->getEmail());
			$adBook->setZip($data->getZip());
			$adBook->setStreet($data->getStreet());
			$adBook->setStreetnr($data->getStreetnr());
			$adBook->setCity($data->getCity());
			$adBook->setCountry($data->getCountry());
			$adBook->setPhonenumber($data->getPhonenumber());
			$adBook->setBirthdate($data->getBirthdate());
			
			

			if($form->get('save')->isClicked() ) {
				$entityManager->persist($adBook);
				$entityManager->flush();

				$repository = $this->getDoctrine()->getRepository(Users::class);

				$users = $repository->findAll();
				return $this->render(
					'form/showall.html.twig',
					['navigation' => $users]
				);
			} else {
				return  $this->redirectToRoute('homepage');
			}
        }

        return $this->render(
            'form/users.html.twig',
            ['form' => $form->createView()]
        );
    }
     /**
     * @Route("/user/{id}/edit", name="user_edit")
     */
    public function editAction(Request $request, Users $user)
    {
        $form = $this->createForm(UsersCollection::class, $user);
        // only handles data on POST
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

	    $directory = $this->getParameter('image_directory');
	    
	    $file = $form['picture']->getData();
	    if(!empty($file)){
	    	$NewFilename = $file->getClientOriginalName();
	    	$file->move($directory, $NewFilename);
	    	$user->setPictureurl($NewFilename);
	    }

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
	    
            $name = $user->getEmail();		
            $flashbag = $this->get('session')->getFlashBag();
            $this->addFlash('success', "User '{$name}' updated!");
            return $this->redirectToRoute('homepage');
        }
        return $this->render('form/edit.html.twig', [
            'form' => $form->createView(), 'pic_url' => $user->getPictureurl()
        ]);
    }
    
    public function showAction($email)
	{
		$repository = $this->getDoctrine()->getRepository(Users::class);

		$users = $repository->findAll();
		return $this->render(
            'form/showall.html.twig',
            ['navigation' => $users]
        );

		// ... do something, like pass the $product object into a template
	}

	// if you have multiple entity managers, use the registry to fetch them
	public function updateAction($userId)
	{
		$entityManager = $this->getDoctrine()->getManager();
		$user = $entityManager->getRepository(Users::class)->find($userId);

		if (!$user) {
			throw $this->createNotFoundException(
				'No product found for id '.$productId
			);
		}

		$user->setName('New product name!');
		$entityManager->flush();
		return $this->redirectToRoute('homepage');
	}
	// if you have multiple entity managers, use the registry to fetch them
	public function deleteAction($userId)
	{
		$entityManager = $this->getDoctrine()->getManager();
		$user = $entityManager->getRepository(Users::class)->find($userId);
		$name = $user->getEmail();
		if (!$user) {
			throw $this->createNotFoundException(
				'No product found for id '.$userId
			);
		}

		$entityManager->remove($user);
		$entityManager->flush();
		$flashbag = $this->get('session')->getFlashBag();
                $this->addFlash('warning', "User '{$name}' Deleted!");
		return $this->redirectToRoute('homepage');
	}
}
