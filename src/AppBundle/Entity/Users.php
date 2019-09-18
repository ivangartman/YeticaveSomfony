<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UsersRepository")
 * @ORM\Table(name="users")
 * @UniqueEntity(fields={"email"}, message="Пользователь с этим E-mail уже зарегистрирован")
 */
class Users implements UserInterface, \Serializable
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_add", type="datetime")
     */
    private $dateAdd;

    public function __construct()
    {
        $this->dateAdd = new \DateTime();
    }

    /**
     * @var string
     *
     * @Assert\NotBlank(
     *     message="Введите E-mail"
     * )
     * @Assert\Length(
     *      max = 120,
     *      maxMessage = "Наименование не должно быть длиннее {{ limit }} символов"
     * )
     * @Assert\Email(
     *     message = "'{{ value }}' не корректное значение E-mail",
     *     checkMX = true
     * )
     *
     * @ORM\Column(name="email", type="string", length=120, unique=true)
     */
    private $email;

    /**
     * @var string
     *
     * @Assert\NotBlank(
     *     message="Введите имя"
     * )
     * @Assert\Length(
     *      max = 60,
     *      maxMessage = "Наименование не должно быть длиннее {{ limit }} символов"
     * )
     *
     * @ORM\Column(name="name", type="string", length=60)
     */
    private $name;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max=4096)
     */
    private $plainPassword;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=120)
     */
    private $password;

    /**
     * @var string
     *
     * @Assert\NotBlank(
     *     message="Напишите как с вами связаться"
     * )
     * @Assert\Length(
     *      max = 120,
     *      maxMessage = "Наименование не должно быть длиннее {{ limit }} символов"
     * )
     *
     * @ORM\Column(name="contact", type="string", length=120, nullable=true)
     */
    private $contact;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set dateAdd
     *
     * @param \DateTime $dateAdd
     *
     * @return Users
     */
    public function setDateAdd($dateAdd)
    {
        $this->dateAdd = $dateAdd;

        return $this;
    }

    /**
     * Get dateAdd
     *
     * @return \DateTime
     */
    public function getDateAdd()
    {
        return $this->dateAdd;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Users
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Users
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * @param   mixed  $plainPassword
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return Users
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set contact
     *
     * @param string $contact
     *
     * @return Users
     */
    public function setContact($contact)
    {
        $this->contact = $contact;

        return $this;
    }

    /**
     * Get contact
     *
     * @return string
     */
    public function getContact()
    {
        return $this->contact;
    }

    /**
     * Returns the roles granted to the user.
     *
     *     public function getRoles()
     *     {
     *         return ['ROLE_USER'];
     *     }
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return (Role|string)[] The user roles
     */
    public function getRoles()
    {
        // TODO: Implement getRoles() method.
        return [
            'ROLE_USER'
        ];
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        // TODO: Implement getSalt() method.
        return null;
    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername()
    {
        // TODO: Implement getUsername() method.
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    /**
     * String representation of object
     *
     * @link  https://php.net/manual/en/serializable.serialize.php
     * @return string the string representation of the object or null
     * @since 5.1.0
     */
    public function serialize()
    {
        // TODO: Implement serialize() method.
        return serialize([
            $this->id,
            $this->contact,
            $this->dateAdd,
            $this->email,
            $this->name,
            $this->password,
        ]);
    }

    /**
     * Constructs the object
     *
     * @link  https://php.net/manual/en/serializable.unserialize.php
     *
     * @param $string
     *
     * @return void
     * @since 5.1.0
     */
    public function unserialize($string)
    {

        list(
            $this->id,
            $this->contact,
            $this->dateAdd,
            $this->email,
            $this->name,
            $this->password,
            ) = unserialize($string, ['allowed_classes' => false]);
    }
}
