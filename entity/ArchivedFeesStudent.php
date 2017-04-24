<?php

namespace ArticleBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ArchivedFeesStudent
 *
 * @ORM\Table(name="archived_fees_student")
 * @ORM\Entity(repositoryClass="ArticleBundle\Repository\ArchivedFeesStudentRepository")
 */
class ArchivedFeesStudent
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
     * @ORM\Column(name="scolarYear", type="string", length=255)
     */
    private $scolarYear;

    /**
     * @var string
     *
     * @ORM\Column(name="civilYear", type="string", length=255)
     */
    private $civilYear;

    /**
     * @var int
     *
     * @ORM\Column(name="amountToBePayed", type="integer")
     */
    private $amountToBePayed;

    /**
     * @var int
     *
     * @ORM\Column(name="examFees", type="integer")
     */
    private $examFees;

    /**   
     *
     * @ORM\ManyToOne(targetEntity="ArticleBundle\Entity\Student", inversedBy="archivedFees")
     * @ORM\JoinColumn(name="student_id", referencedColumnName="id")
     */
    private $student;

    /**   
     *
     * @ORM\OneToMany(targetEntity="ArticleBundle\Entity\AmountPayed", mappedBy="archivedFees", cascade={"remove"})    
     */
    private $amountPayed;


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
     * Set scolarYear
     *
     * @param string $scolarYear
     *
     * @return ArchivedFeesStudent
     */
    public function setScolarYear($scolarYear)
    {
        $this->scolarYear = $scolarYear;

        return $this;
    }

    /**
     * Get scolarYear
     *
     * @return string
     */
    public function getScolarYear()
    {
        return $this->scolarYear;
    }

    /**
     * Set civilYear
     *
     * @param string $civilYear
     *
     * @return ArchivedFeesStudent
     */
    public function setCivilYear($civilYear)
    {
        $this->civilYear = $civilYear;

        return $this;
    }

    /**
     * Get civilYear
     *
     * @return string
     */
    public function getCivilYear()
    {
        return $this->civilYear;
    }

    /**
     * Set amountToBePayed
     *
     * @param integer $amountToBePayed
     *
     * @return ArchivedFeesStudent
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
     * Set examFees
     *
     * @param integer $examFees
     *
     * @return ArchivedFeesStudent
     */
    public function setExamFees($examFees)
    {
        $this->examFees = $examFees;

        return $this;
    }

    /**
     * Get examFees
     *
     * @return int
     */
    public function getExamFees()
    {
        return $this->examFees;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->amountPayed = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set student
     *
     * @param \ArticleBundle\Entity\Student $student
     *
     * @return ArchivedFeesStudent
     */
    public function setStudent(\ArticleBundle\Entity\Student $student = null)
    {
        $this->student = $student;

        return $this;
    }

    /**
     * Get student
     *
     * @return \ArticleBundle\Entity\Student
     */
    public function getStudent()
    {
        return $this->student;
    }

    /**
     * Add amountPayed
     *
     * @param \ArticleBundle\Entity\AmountPayed $amountPayed
     *
     * @return ArchivedFeesStudent
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
}
