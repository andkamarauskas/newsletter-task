<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;

use AppBundle\Service\UserDataService;
use AppBundle\Service\CategoryDataService;

use AppBundle\Form\UserType;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class UserController extends Controller
{
    private $userDataService;

    function __construct(UserDataService $userDataService) {
        $this->userDataService = $userDataService;
    }

    // /**
    //  * @Route("/users", name="users")
    //  */
    // public function indexAction(Request $request,CategoryDataService $categoryDataService)
    // {
    // 	$users = $this->userDataService->getAllUsers();
    //     $categories = $categoryDataService->getCategories();

    // 	return $this->render('users/index.html.twig', array(
    // 		'users' => $users,
    //         'categories' => $categories
    // 	));
    // }

    /**
     * @Route("/users/by/{sortBy}", name="users")
     */
    public function sortedAction(Request $request,CategoryDataService $categoryDataService, $sortBy)
    {
        $users = $this->userDataService->getAllUsers($sortBy);
        if(!$users){
            $this->addFlash('info', 'No Any Users');
        }
        $categories = $categoryDataService->getCategories();

        return $this->render('users/index.html.twig', array(
            'users' => $users,
            'categories' => $categories,
            'sorted' => $sortBy
        ));
    }

    /**
     * @Route("/users/delete/{id}", name="userdelete")
     */
    public function deleteAction($id)
    {
    	$this->userDataService->deleteUser($id);
    	$this->addFlash('danger', 'User was removed.');
    	return $this->redirectToRoute('users');
    }

    /**
     * @Route("/users/edit/{id}", name="useredit")
     */
    public function editAction(Request $request,$id,CategoryDataService $categoryDataService)
    {
        $user = $this->userDataService->getUser($id);
        if(!$user)
        {
            return $this->redirectToRoute('users');
        }

        $categories = $categoryDataService->getCategories();

        $form = $this->createForm(UserType::class, $user, array('categories' => array_flip($categories)));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $this->userDataService->updateUser($id,$form->getData());

            $this->addFlash('success', $user->getName().' profile was updated.');
            
            return $this->redirectToRoute('users');
        }


        return $this->render('newsletter/index.html.twig', [
            'form' => $form->createView(),
            'form_title' => 'Edit User Info'
        ]);
    }
}
