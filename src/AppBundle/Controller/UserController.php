<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;

use AppBundle\Service\DataService;

use AppBundle\Form\UserType;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class UserController extends Controller
{
    /**
     * @Route("/users", name="users")
     */
    public function indexAction(Request $request, DataService $dataService)
    {
    	$users = $dataService->getAllUsers();

    	return $this->render('users/index.html.twig', array(
    		'users' => $users
    	));
    }

    /**
     * @Route("/users/delete/{id}", name="userdelete")
     */
    public function deleteAction($id, DataService $dataService)
    {
    	$users = $dataService->deleteUser($id);
    	
    	return $this->redirectToRoute('users');
    }

    /**
     * @Route("/users/edit/{id}", name="useredit")
     */
    public function editAction(Request $request,$id, DataService $dataService)
    {
        $user = $dataService->getUser($id);
        if(!$user)
        {
            return $this->redirectToRoute('users');
        }

        $categories = $dataService->getNewsletterCategories();

        $form = $this->createForm(UserType::class, $user, array('categories' => $categories));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $dataService->updateUser($id,$form->getData());

            return $this->redirectToRoute('users');
        }

        return $this->render('newsletter/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
