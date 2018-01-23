<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;

use AppBundle\Service\UserDataService;
use AppBundle\Service\CategoryDataService;

use AppBundle\Form\UserType;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class NewsletterController extends Controller
{
    /**
     * @Route("/", name="mainpage")
     */
    public function indexAction(Request $request, CategoryDataService $categoryDataService, UserDataService $userDataService)
    {
        $categories = $categoryDataService->getCategories();

        $user = new User();
        $form = $this->createForm(UserType::class, $user, array('categories' => array_flip($categories)));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $userDataService->saveUser($form->getData());

            $this->addFlash("success", $form->getData()->getName() . ' successful registreted!');

            return $this->redirectToRoute('mainpage');
        }

        return $this->render('newsletter/index.html.twig', [
            'form' => $form->createView(),
            'form_title' => 'Registration for Newsletter'
        ]);
    }
}
