<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Lots
 *
 * @ORM\Table(name="lots")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\LotsRepository")
 */
class Lots
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
     * @var Users|null
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Users")
     */
    private $user;

    /**
     * @var Category|null
     * @Assert\NotNull(
     *     message="Выберите категорию"
     * )
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Category")
     */
    private $category;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_add", type="datetime")
     */
    private $dateAdd;

    public function __construct()
    {
        $this->dateAdd = new \DateTime();
//        $this->user = 11;
    }

    /**
     * @var string
     *
     * @Assert\NotNull(
     *     message="Введите наименование лота"
     * )
     * @Assert\Length(
     *      max = 30,
     *      maxMessage = "Наименование не должно быть длиннее {{ limit }} символов"
     * )
     *
     * @ORM\Column(name="name", type="string", length=120)
     */
    private $name;

    /**
     * @var string
     *
     * @Assert\NotNull(
     *     message="Введите наименование лота"
     * )
     * @Assert\Length(
     *      max = 500,
     *      maxMessage = "Описание не должно быть длиннее {{ limit }} символов"
     * )
     *
     * @ORM\Column(name="content", type="text", nullable=true)
     */
    private $content;

    /**
     * @var string
     *
     * @Assert\NotNull(
     *     message="Загрузите изображение"
     * )
     * @Assert\Image(
     *     mimeTypesMessage = "Этот файл не является валидным изображением"
     * )
     *
     * @ORM\Column(name="picture_url", type="string", nullable=true)
     */
    private $pictureUrl;

    /**
     * @var int
     *
     * @Assert\NotNull(
     *     message="Введите начальную цену"
     * )
     * @Assert\Length(
     *      max = 11,
     *      maxMessage = "Введите не более {{ limit }} цифр"
     * )
     *
     * @ORM\Column(name="price", type="integer")
     */
    private $price;

    /**
     * @var \DateTime
     *
     * @Assert\NotNull(
     *     message="Введите дату завершения торгов"
     * )
     * @Assert\Date(
     *     message="Введите дату в формате ГГГГ-ММ-ДД"
     * )
     *
     * @ORM\Column(name="date_end", type="datetime", nullable=true)
     */
    private $dateEnd;

    /**
     * @var int
     *
     * @Assert\NotNull(
     *     message="Введите шаг ставки"
     * )
     * @Assert\Length(
     *      max = 11,
     *      maxMessage = "Введите не более {{ limit }} цифр"
     * )
     *
     * @ORM\Column(name="step_rate", type="integer", nullable=true)
     */
    private $stepRate;

    /**
     * @var int
     *
     * @ORM\Column(name="winner_id", type="integer", nullable=true)
     */
    private $winnerId;


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
     * Set user
     *
     * @param string $user
     *
     * @return Lots
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return Users|null
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set category
     *
     * @param string $category
     *
     * @return Lots
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return Category|null
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set dateAdd
     *
     * @param \DateTime $dateAdd
     *
     * @return Lots
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
     * Set name
     *
     * @param string $name
     *
     * @return Lots
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
     * Set content
     *
     * @param string $content
     *
     * @return Lots
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set pictureUrl
     *
     * @param string $pictureUrl
     *
     * @return Lots
     */
    public function setPictureUrl($pictureUrl)
    {
        $this->pictureUrl = $pictureUrl;

        return $this;
    }

    /**
     * Get pictureUrl
     *
     * @return string
     */
    public function getPictureUrl()
    {
        return $this->pictureUrl;
    }

    /**
     * Set price
     *
     * @param integer $price
     *
     * @return Lots
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return int
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set dateEnd
     *
     * @param \DateTime $dateEnd
     *
     * @return Lots
     */
    public function setDateEnd($dateEnd)
    {
        $this->dateEnd = $dateEnd;

        return $this;
    }

    /**
     * Get dateEnd
     *
     * @return \DateTime
     */
    public function getDateEnd()
    {
        return $this->dateEnd;
    }

    /**
     * Set stepRate
     *
     * @param integer $stepRate
     *
     * @return Lots
     */
    public function setStepRate($stepRate)
    {
        $this->stepRate = $stepRate;

        return $this;
    }

    /**
     * Get stepRate
     *
     * @return int
     */
    public function getStepRate()
    {
        return $this->stepRate;
    }

    /**
     * Set winnerId
     *
     * @param integer $winnerId
     *
     * @return Lots
     */
    public function setWinnerId($winnerId)
    {
        $this->winnerId = $winnerId;

        return $this;
    }

    /**
     * Get winnerId
     *
     * @return int
     */
    public function getWinnerId()
    {
        return $this->winnerId;
    }
}

