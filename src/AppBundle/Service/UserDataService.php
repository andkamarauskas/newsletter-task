<?php

namespace AppBundle\Service;

use AppBundle\Entity\User;

class UserDataService 
{
	private $usersPath;
    private $users;

    function __construct() 
    {    
        $this->usersPath = realpath('../var') . '/data/newsletter/users.json';
        $this->directoryCheck();
        $usersJson = file_get_contents($this->usersPath);
        $this->users = json_decode($usersJson);
    }

    public function directoryCheck()
    {
        if(!file_exists($this->usersPath))
        {
            $path = realpath('../var') . '/data/newsletter';
            if(!file_exists($path)){
                mkdir($path, 0777, true);
            }
            file_put_contents($this->usersPath, json_encode([]));
        }
    }

    public function getAllUsers($sortBy)
    {
        if(count($this->users) > 0)
        {
            $this->sortUsersBy($sortBy);
            return $this->users;
        }
        else
        {
            return false;
        }
        
    }

    public function sortUsersBy($sortBy)
    {
        switch ($sortBy) 
        {
            case 'name':
                usort($this->users, function ($a, $b)
                {
                    return strcmp($a->name, $b->name);
                });
                break;

            case 'email':
                usort($this->users, function ($a, $b)
                {
                    return strcmp($a->email, $b->email);
                });
                break;
            
            default:
                usort( $this->users, function( $a, $b )
                {
                    if ( $a->createdAt == $b->createdAt )
                    {
                        return 0;
                    }
                    else
                    {
                        return ( $a->createdAt < $b->createdAt ) ? -1 : 1;
                    }
                });
                break;
        }
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
        if($this->users){
            $lastuser = end($this->users);
            $id = $lastuser->id + 1;
        }else{
            $id = 1;
        }
        
        $datetime = new \DateTime();

        $user = [
            'id' => $id,
            'name' => $userData->getName(),
            'email' => $userData->getEmail(),
            'categories' => $userData->getCategories(),
            'createdAt' => $datetime->format('Y-m-d H:i:s')
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
                $categories = $userData->getCategories();
                if(count($categories) == 0){
                    $user->categories = [0];
                    print_r('here');
                }else{
                    $user->categories = $categories;
                }
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