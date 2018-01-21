<?php

namespace AppBundle\Service;

use AppBundle\Entity\User;

class DataService
{
    private $dataPath;

    function __construct() {
        $this->dataPath = realpath('../var/data/newsletter');
    }

    public function getNewsletterCategories()
    {
        $categoriesPath = $this->dataPath . '/categories.json';
        $categories = json_decode(file_get_contents($categoriesPath));

        return (array)$categories;
    }

    public function getAllUsers()
    {
        $usersPath = $this->dataPath . '/users.json';
        $usersJson = file_get_contents($usersPath);
        $users = json_decode($usersJson);

        return $users;
    }

    public function getUser($id)
    {
        $usersPath = $this->dataPath . '/users.json';
        $usersJson = file_get_contents($usersPath);
        $users = json_decode($usersJson);

        foreach ($users as $user) 
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
        $usersPath = $this->dataPath . '/users.json';
        $usersJson = file_get_contents($usersPath);
        $users = (array)json_decode($usersJson);

        $lastuser = end($users);
        $id = $lastuser ? $lastuser->id + 1 : 1;
        
        $user = [
            'id' => $id,
            'name' => $userData->getName(),
            'email' => $userData->getEmail(),
            'categories' => $userData->getCategories(),
        ];

        $users[] = $user;

        $usersJson = json_encode($users);
        file_put_contents($usersPath, $usersJson);
    }

    public function updateUser($id,$userData)
    {
        $usersPath = $this->dataPath . '/users.json';
        $usersJson = file_get_contents($usersPath);
        $users = (array)json_decode($usersJson);

        $updateUsers = [];
        foreach ($users as $user) 
        {
            if($user->id == $id)
            {   
                $user->name = $userData->getName();
                $user->email = $userData->getEmail();
                $user->categories = $userData->getCategories();
            }

            $updateUsers[] = $user;
        }
        $users = $updateUsers;
        
        $usersJson = json_encode($users);
        file_put_contents($usersPath, $usersJson);
    }

    public function deleteUser($id)
    {
        $usersPath = $this->dataPath . '/users.json';
        $usersJson = file_get_contents($usersPath);
        $users = json_decode($usersJson);

        $filtredUsers = [];
        foreach ($users as $user) 
        {
            if($user->id == $id)
            {   
                continue;
            }

            $filtredUsers[] = $user;
        }
        $users = $filtredUsers;
        
        $usersJson = json_encode($users);
        file_put_contents($usersPath, $usersJson);
    }

}