<?php

namespace App\Entity;

use App\Exceptions\Security\InvalidArgumentSuppliedException;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="users")
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\Column(name="first_name", type="string", nullable=false)
     */
    protected $firstName;

    /**
     * @ORM\Column(name="last_name", type="string", nullable=false)
     */
    protected $lastName;

    /**
     * @ORM\Column(name="username", type="string", nullable=false)
     */
    protected $username;

    /**
     * @ORM\Column(name="password", type="string", nullable=false)
     */
    protected $password;

    /**
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    protected $createdAt;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\AuthenticationToken", cascade={"remove"}, mappedBy="user", orphanRemoval=true)
     */
    protected $tokens;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param mixed $firstName
     */
    public function setFirstName($firstName)
    {
        if (!$firstName) {
            throw new InvalidArgumentSuppliedException('First name cannot be empty');
        }
        $this->firstName = $firstName;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName($lastName)
    {
        if (!$lastName) {
            throw new InvalidArgumentSuppliedException('Last name cannot be empty');
        }
        $this->lastName = $lastName;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        if (!$username) {
            throw new InvalidArgumentSuppliedException('Username cannot be empty');
        }
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        if (!$password) {
            throw new InvalidArgumentSuppliedException('Password cannot be empty');
        }
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        if (!$createdAt) {
            throw new InvalidArgumentSuppliedException('CreatedAt cannot be empty');
        }
        $this->createdAt = $createdAt;
    }
}