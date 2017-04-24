<?php

namespace ArticleBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AmountPayed
 *
 * @ORM\Table(name="amount_payed")
 * @ORM\Entity(repositoryClass="ArticleBundle\Repository\AmountPayedRepository")
 */
class AmountPayed
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
     * @ORM\Column(name="payment", type="integer")
     */
    private $payment;

    /**
     * @var datetime
     *
     * @ORM\Column(name="datePayment", type="datetime")
     */
    private $datePayment;

    /**
     * @var int
     *
     * @ORM\Column(name="paymentMethod", type="integer")
     */
    private $paymentMethod;

     /**
     * @var string
     *
     * @ORM\Column(name="scholarYear", type="string", length=10)
     */
    private $scholarYear;

    /**
     *
     * @ORM\ManyToOne(targetEntity="ArticleBundle\Entity\Student", inversedBy="amountPayed")
     * @ORM\JoinColumn(name="student_id", referencedColumnName="id")
     */
    private $student;

     /**
     *
     * @ORM\ManyToOne(targetEntity="ArticleBundle\Entity\Amount", inversedBy="amountPayed")
     * @ORM\JoinColumn(name="amount_id", referencedColumnName="id")
     */
    private $amount;

    /**
     *
     * @ORM\ManyToOne(targetEntity="ArticleBundle\Entity\ArchivedFeesStudent", inversedBy="amountPayed")
     * @ORM\JoinColumn(name="archivedFees_id", referencedColumnName="id", nullable=true)
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

    /**
     * Set payment
     *
     * @param integer $payment
     *
     * @return AmountPayed
     */
    public function setPayment($payment)
    {
        $this->payment = $payment;

        return $this;
    }

    /**
     * Get payment
     *
     * @return int
     */
    public function getPayment()
    {
        return $this->payment;
    }   

    /**
     * Set paymentMethod
     *
     * @param string $paymentMethod
     *
     * @return AmountPayed
     */
    public function setPaymentMethod($paymentMethod)
    {
        $this->paymentMethod = $paymentMethod;

        return $this;
    }

    /**
     * Get paymentMethod
     *
     * @return string
     */
    public function getPaymentMethod()
    {
        return $this->paymentMethod;
    }

    /**
     * Set student
     *
     * @param \ArticleBundle\Entity\Student $student
     *
     * @return AmountPayed
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
     * Set amount
     *
     * @param \ArticleBundle\Entity\Amount $amount
     *
     * @return AmountPayed
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
     * Set datePayment
     *
     * @param \DateTime $datePayment
     *
     * @return AmountPayed
     */
    public function setDatePayment($datePayment)
    {
        $this->datePayment = $datePayment;

        return $this;
    }

    /**
     * Get datePayment
     *
     * @return \DateTime
     */
    public function getDatePayment()
    {
        return $this->datePayment;
    }

    /**
     * Set scholarYear
     *
     * @param string $scholarYear
     *
     * @return AmountPayed
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
     * Set archivedFees
     *
     * @param \ArticleBundle\Entity\ArchivedFeesStudent $archivedFees
     *
     * @return AmountPayed
     */
    public function setArchivedFees(\ArticleBundle\Entity\ArchivedFeesStudent $archivedFees = null)
    {
        $this->archivedFees = $archivedFees;

        return $this;
    }

    /**
     * Get archivedFees
     *
     * @return \ArticleBundle\Entity\ArchivedFeesStudent
     */
    public function getArchivedFees()
    {
        return $this->archivedFees;
    }
}
