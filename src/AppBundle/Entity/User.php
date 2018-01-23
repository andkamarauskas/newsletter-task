<?php
// src/AppBundle/Entity/User.php
namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class User
{
    /**
     * @Assert\NotBlank()
     */
    protected $name;

    /**
     * @Assert\NotBlank()
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email.",
     *     checkMX = true
     * )
     */
    protected $email;

    /**
     * @Assert\NotBlank()
     * @Assert\Type(
     *     type="array",
     *     message="The value {{ value }} is not a valid {{ type }}."
     * )
     */
    protected $categories;

    protected $createdAt;


    public function getId()
    {
        return $this->name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getCategories()
    {
        return $this->categories;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setCategories($categories)
    {
        $this->categories = $categories;
    }

    public function setCreatedAt($datetime)
    {
        $this->createdAt = $datetime;
    }

}