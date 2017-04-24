<?php

namespace ArticleBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Student
 *
 * @ORM\Table(name="student")
 * @ORM\Entity(repositoryClass="ArticleBundle\Repository\StudentRepository")
 * @UniqueEntity("mail")
 */
class Student
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=255)
     */
    private $firstname;

    /**
     * @var \Date
     *
     * @ORM\Column(name="birthdate", type="date")
     */
    private $birthdate;


    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255)
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="postCode", type="string", length=255)
     */
    private $postCode;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="mail", type="string", length=255, unique=true)
     */
    private $mail;

    /**
     * @var int
     *
     * @ORM\Column(name="fix", type="integer", nullable=true)
     */
    private $fix;

    /**
     * @var int
     *
     * @ORM\Column(name="mobile", type="integer")
     */
    private $mobile;

    /**
     * @var int
     *
     * @ORM\Column(name="archived", type="integer")
     */
    private $archived=1;    

    /**     
     *
     * @ORM\OneToMany(targetEntity="ArticleBundle\Entity\AmountPayed", mappedBy="student")
     */
    private $amountPayed;

    /**     
     *
     * @ORM\ManyToOne(targetEntity="ArticleBundle\Entity\Amount", inversedBy="student")
     * @ORM\JoinColumn(name="amount_id")
     *
     */
    private $amount;

    /**     
     *
     * @ORM\OneToMany(targetEntity="ArticleBundle\Entity\ArchivedFeesStudent", mappedBy="student", cascade={"remove"})
     */
    private $archivedFees;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    public function getFullName()
    {
        return $this->getFirstname(). ' ' . $this->getName();
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Student
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
     * Set firstname
     *
     * @param string $firstname
     *
     * @return Student
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set birthdate
     *
     * @param \DateTime $birthdate
     *
     * @return Student
     */
    public function setBirthdate($birthdate)
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    /**
     * Get birthdate
     *
     * @return \DateTime
     */
    public function getBirthdate()
    {
        return $this->birthdate;
    }

   
    /**
     * Set address
     *
     * @param string $address
     *
     * @return Student
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set postCode
     *
     * @param string $postCode
     *
     * @return Student
     */
    public function setPostCode($postCode)
    {
        $this->postCode = $postCode;

        return $this;
    }

    /**
     * Get postCode
     *
     * @return string
     */
    public function getPostCode()
    {
        return $this->postCode;
    }

    /**
     * Set city
     *
     * @param string $city
     *
     * @return Student
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->amountPayed = new \Doctrine\Common\Collections\ArrayCollection();
        $this->amount = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add amountPayed
     *
     * @param \ArticleBundle\Entity\AmountPayed $amountPayed
     *
     * @return Student
     */
    public function addAmountPayed(\ArticleBundle\Entity\AmountPayed $amountPayed)
    {
        $this->amountPayed[] = $amountPayed;

        return $this;
    }

    /**
     * Remove amountPayed
     *
     * @param \ArticleBundle\Entity\AmountPayed $amountPayed
     */
    public function removeAmountPayed(\ArticleBundle\Entity\AmountPayed $amountPayed)
    {
        $this->amountPayed->removeElement($amountPayed);
    }

    /**
     * Get amountPayed
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAmountPayed()
    {
        return $this->amountPayed;
    }

    /**
     * Set archived
     *
     * @param integer $archived
     *
     * @return Student
     */
    public function setArchived($archived)
    {
        $this->archived = $archived;

        return $this;
    }

    /**
     * Get archived
     *
     * @return integer
     */
    public function getArchived()
    {
        return $this->archived;
    }

    /**
     * Set mail
     *
     * @param string $mail
     *
     * @return Student
     */
    public function setMail($mail)
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * Get mail
     *
     * @return string
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * Set fix
     *
     * @param string $fix
     *
     * @return Student
     */
    public function setFix($fix)
    {
        $this->fix = $fix;

        return $this;
    }

    /**
     * Get fix
     *
     * @return string
     */
    public function getFix()
    {
        return $this->fix;
    }

    /**
     * Set mobile
     *
     * @param string $mobile
     *
     * @return Student
     */
    public function setMobile($mobile)
    {
        $this->mobile = $mobile;

        return $this;
    }

    /**
     * Get mobile
     *
     * @return string
     */
    public function getMobile()
    {
        return $this->mobile;
    }      

   

    /**
     * Set amount
     *
     * @param \ArticleBundle\Entity\Amount $amount
     *
     * @return Student
     */
    public function setAmount(\ArticleBundle\Entity\Amount $amount = null)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return \ArticleBundle\Entity\Amount
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Add archivedFee
     *
     * @param \ArticleBundle\Entity\ArchivedFeesStudent $archivedFee
     *
     * @return Student
     */
    public function addArchivedFee(\ArticleBundle\Entity\ArchivedFeesStudent $archivedFee)
    {
        $this->archivedFees[] = $archivedFee;

        return $this;
    }

    /**
     * Remove archivedFee
     *
     * @param \ArticleBundle\Entity\ArchivedFeesStudent $archivedFee
     */
    public function removeArchivedFee(\ArticleBundle\Entity\ArchivedFeesStudent $archivedFee)
    {
        $this->archivedFees->removeElement($archivedFee);
    }

    /**
     * Get archivedFees
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getArchivedFees()
    {
        return $this->archivedFees;
    }
}
