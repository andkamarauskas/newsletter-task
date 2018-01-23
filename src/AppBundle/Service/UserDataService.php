<?php

namespace AppBundle\Service;

use AppBundle\Entity\User;

class UserDataService 
{
	private $usersPath;
    private $users;

    function __construct() {
        $this->usersPath = realpath('../var/data/newsletter/users.json');
        $usersJson = file_get_contents($this->usersPath);
        $this->users = json_decode($usersJson);
    }

    public function getAllUsers()
    {
        return $this->users;
    }

    public function getUser($id)
    {
        foreach ($this->users as $user) 
        {
            if($user->id == $id)
            {   
                $userEntity = new User();
                $userEntity->setId($id);
                $userEntity->setName($user->name);
                $userEntity->setEmail($user->email);
                $userEntity->setCategories($user->categories);

                return $userEntity;
            }

        }

        return false;
    }

    public function saveUser($userData)
    {
        $lastuser = end($this->users);
        $id = $lastuser ? $lastuser->id + 1 : 1;
        
        $user = [
            'id' => $id,
            'name' => $userData->getName(),
            'email' => $userData->getEmail(),
            'categories' => $userData->getCategories(),
        ];

        $this->users[] = $user;
        $this->saveToJson();
    }

    public function updateUser($id,$userData)
    {
        $updateUsers = [];
        foreach ($this->users as $user) 
        {
            if($user->id == $id)
            {   
                $user->name = $userData->getName();
                $user->email = $userData->getEmail();
                $user->categories = $userData->getCategories();
            }

            $updateUsers[] = $user;
        }
        $this->users = $updateUsers;
        $this->saveToJson();
    }

    public function deleteUser($id)
    {
        $filtredUsers = [];
        foreach ($this->users as $user) 
        {
            if($user->id == $id)
            {   
                continue;
            }

            $filtredUsers[] = $user;
        }
        $this->users = $filtredUsers;
        $this->saveToJson();
    }

    public function saveToJson()
    {
        $usersJson = json_encode($this->users);
        file_put_contents($this->usersPath, $usersJson);
    }
}