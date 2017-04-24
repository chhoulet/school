<?php

namespace ArticleBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Amount
 *
 * @ORM\Table(name="amount")
 * @ORM\Entity(repositoryClass="ArticleBundle\Repository\AmountRepository")
 */
class Amount
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
     * @var int
     *
     * @ORM\Column(name="amountToBePayed", type="integer")
     */
    private $amountToBePayed;

    /**
     * @var int
     *
     * @ORM\Column(name="examFees", type="integer", nullable=true)
     */
    private $examFees;

    /**
     * @var string
     *
     * @ORM\Column(name="scholarYear", type="string", length=10)
     */
    private $scholarYear;

     /**
     * @var string
     *
     * @ORM\Column(name="civilYear", type="string", length=10)
     */
    private $civilYear;

     /**   
     *
     * @ORM\OneToMany(targetEntity="ArticleBundle\Entity\AmountPayed", mappedBy="amount", cascade={"remove"})
     */
    private $amountPayed;

     /**   
     *
     * @ORM\OneToMany(targetEntity="ArticleBundle\Entity\Student", mappedBy="amount")    
     */
    private $student;

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
     * Set amountToBePayed
     *
     * @param integer $amountToBePayed
     *
     * @return Amount
     */
    public function setAmountToBePayed($amountToBePayed)
    {
        $this->amountToBePayed = $amountToBePayed;

        return $this;
    }

    /**
     * Get amountToBePayed
     *
     * @return int
     */
    public function getAmountToBePayed()
    {
        return $this->amountToBePayed;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->amountPayed = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set scholarYear
     *
     * @param string $scholarYear
     *
     * @return Amount
     */
    public function setScholarYear($scholarYear)
    {
        $this->scholarYear = $scholarYear;

        return $this;
    }

    /**
     * Get scholarYear
     *
     * @return string
     */
    public function getScholarYear()
    {
        return $this->scholarYear;
    }

    /**
     * Set civilYear
     *
     * @param integer $civilYear
     *
     * @return Amount
     */
    public function setCivilYear($civilYear)
    {
        $this->civilYear = $civilYear;

        return $this;
    }

    /**
     * Get civilYear
     *
     * @return integer
     */
    public function getCivilYear()
    {
        return $this->civilYear;
    }

    /**
     * Add amountPayed
     *
     * @param \ArticleBundle\Entity\AmountPayed $amountPayed
     *
     * @return Amount
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
     * Set examFees
     *
     * @param integer $examFees
     *
     * @return Amount
     */
    public function setExamFees($examFees)
    {
        $this->examFees = $examFees;

        return $this;
    }

    /**
     * Get examFees
     *
     * @return integer
     */
    public function getExamFees()
    {
        return $this->examFees;
    }    

    /**
     * Add student
     *
     * @param \ArticleBundle\Entity\Student $student
     *
     * @return Amount
     */
    public function addStudent(\ArticleBundle\Entity\Student $student)
    {
        $this->student[] = $student;

        return $this;
    }

    /**
     * Remove student
     *
     * @param \ArticleBundle\Entity\Student $student
     */
    public function removeStudent(\ArticleBundle\Entity\Student $student)
    {
        $this->student->removeElement($student);
    }

    /**
     * Get student
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getStudent()
    {
        return $this->student;
    }
}
