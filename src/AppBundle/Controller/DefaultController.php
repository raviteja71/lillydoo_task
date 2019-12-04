<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Form\UsersCollection;
use AppBundle\Entity\Users;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        
		$repository = $this->getDoctrine()->getRepository(Users::class);

		$products = $repository->findAll();
		return $this->render(
            'form/showall.html.twig',
            ['navigation' => $products]
        );
    }
}
