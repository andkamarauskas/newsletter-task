<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;

use AppBundle\Service\DataService;

use AppBundle\Form\UserType;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class NewsletterController extends Controller
{
    /**
     * @Route("/", name="mainpage")
     */
    public function indexAction(Request $request, DataService $dataService)
    {
        $categories = $dataService->getNewsletterCategories();
        $user = new User();

        $form = $this->createForm(UserType::class, $user, array('categories' => $categories));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $dataService->saveUser($form->getData());

            return $this->redirectToRoute('mainpage');
        }

        return $this->render('newsletter/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
