<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use ArticleBundle\Entity\Document;
use ArticleBundle\Entity\Student;
use ArticleBundle\Entity\Amount;
use ArticleBundle\Entity\AmountPayed;
use ArticleBundle\Entity\ArchivedFeesStudent;
use ArticleBundle\Form\DocumentType;
use ArticleBundle\Form\StudentType;
use ArticleBundle\Form\AmountType;
use ArticleBundle\Form\AmountPayedType;
use ArticleBundle\Form\DocumentSchoolType;
use ArticleBundle\Form\MailSendedType;

class SchoolController extends Controller
{
	public function documentAction(Request $request, $idStudent=null)
	{
		$em=$this->getDoctrine()->getManager();
		$session=$request->getSession();
		$affich=1;
		$listDocs = $em->getRepository('ArticleBundle:Document')->findByPublicDoc(3);

		//Création formulaire envoi mail aux boursiers
		$formMail=$this->createForm(MailSendedType::class);

		//Création formulaire d'upload de document
		$document=new Document();
		$form=$this->createForm(DocumentSchoolType::class, $document);
		//

		//Création formulaire enregistrement de payment
		$amountPayed=new AmountPayed();
		$formPayment=$this->createForm(AmountPayedType::class, $amountPayed);
		//		

		$formMail->handleRequest($request);
		if($formMail->isSubmitted() && $formMail->isValid())
		{
			$listStudents=$em->getRepository('ArticleBundle:Student')->findByArchived(1);
			$listMails=[];
			foreach($listStudents as $student)
			{
				$mail=$student->getMail();
				$listMails[]=$mail;
			}

			$datas=$formMail->getData();

			$mailFrom="contact@egyptembassy.com";
			$subject=$datas['subject'];
			$body=$datas['message'];

			foreach($listMails as $mail)
			{
				$mailTo=$mail;
				$this->get('article_bundle_service_mail')->send($subject, $body, $mailTo, $mailFrom);
			}

			$session->getFlashBag()->add('successMail', 'Yous message has been sended to all the students !');
			return $this->redirectToRoute('admin_school_document', array('idStudent'=>0));
		}		

		$form->handleRequest($request);

		if($form->isValid() && $form->isSubmitted())
		{
			$file=$document->getFile();
			$filename=md5(uniqid()).' '.$file->guessExtension();			
			$file->move($this->getParameter('documents_directory'), $filename);
			$document->setFile($filename);
			$document->setPublicDoc(3);

			$em->persist($document);
			$em->flush();

			$session->getFlashBag()->add('uploadDoc', 'This document has been downloaded with success !');
			return $this->redirectToRoute('admin_school_document', array('idStudent'=>0));
		}


		if($idStudent)
		{
			$listStudents=$em->getRepository('ArticleBundle:Student')->findAll();
			$listIdStudents=[];

			foreach($listStudents as $studen)
			{
				$id=$studen->getId();
				$listIdStudents[]=$id;
			}

			if(in_array($idStudent, $listIdStudents))
			{				
				//Instanciation d'un AmountPayed, montant payé par un student pour ses frais de scolarité				
				$affich=2;			
				$student=$em->getRepository('ArticleBundle:Student')->find($idStudent);
				$amount=$student->getAmount();				

				$formPayment->handleRequest($request);
				if($formPayment->isSubmitted() && $formPayment->isValid())
				{
					$scholarYear=$amount->getScholarYear();
					$amountPayed->setStudent($student);
					$amountPayed->setAmount($amount);
					$amountPayed->setScholarYear($scholarYear);
					$amountPayed->setDatePayment(new \DateTime());
					$amount->addAmountPayed($amountPayed);
					$student->addAmountPayed($amountPayed);
					$em->persist($amountPayed);
					$em->flush();
/*var_dump($amountPayed);die;*/

					$session->getFlashBag()->add('amountPayed','This payment of '. $amountPayed->getPayment() . '£ is registered for '. $student->getFullName());
					return $this->redirectToRoute('admin_school_listAndCreate',
						array('origin'=>1, 'id'=>0));
				}

				return $this->render('AdminBundle:School:document.html.twig', 
					array('formPayment'   =>$formPayment->createView(),						  
						  'form'          =>$form->createView(),
						  'formMail'      =>$formMail->createView(),
						  'listDocs'      =>$listDocs,
						  'affich'        =>$affich,
						  'student'       =>$student));	
			}
			else
			{
				throw new NotFoundHttpException("Student not found");
			}
		}		

		return $this->render('AdminBundle:School:document.html.twig', 
			array('form'          =>$form->createView(),					  
				  'formMail'      =>$formMail->createView(),
				  'listDocs'      =>$listDocs,
				  'affich'        =>1));
	}

	public function listAndCreateAction(Request $request, $origin, $id=null)
	{
		$em=$this->getDoctrine()->getManager();
		$session=$request->getSession();

		// Récupération de l'année en cours
		$dateOfTheYear=new \DateTime();
		$year=$dateOfTheYear->format('Y');
		$yearForSchool=$year+1;
		$yearSchool=$year.'-'.$yearForSchool;
		//

		//Récupération des students 
		$listStudentsNotArchived=$em->getRepository('ArticleBundle:Student')->findAll();

		//Instanciation d'un student
		if($origin == 1)
		{
			$student=new Student();			
		}
		else
		{
			$listIdStudents=[];
			foreach($listStudentsNotArchived as $stud)
			{
				$idStud=$stud->getId();
				$listIdStudents[]=$idStud;
			}

			if(in_array($id, $listIdStudents))
			{
				$student=$em->getRepository('ArticleBundle:Student')->find($id);				
				$amountStudent=$student->getAmount();
				$idAmountStudent=null;
				if($amountStudent)
				{
					$idAmountStudent=$amountStudent->getId();
				}				
			}
			else
			{
				throw new NotFoundHttpException("Student not found");
			}
		}

		$form=$this->createForm(StudentType::class, $student, array('yearSchool'=>$yearSchool));		

		$form->handleRequest($request);
	
		if($form->isSubmitted() && $form->isValid())
		{			
			if($origin == 1)
			{
				$em->persist($student);
			}
			//Attribution des versements déjà effectués au paiement des frais de la nouvelle année scolaire sélectionnée lors de l'update
			else
			{
				if($amountStudent)
				{
					$amountForm=$student->getAmount();				
					// On vérifie s'il y a changement d'année scolaire - donc d'Amount dans Doctrine-
					if($amountForm->getId() != $idAmountStudent)
					{
						$updatedAmount=$em->getRepository('ArticleBundle:Amount')->find($amountForm->getId());						
						$listPaymentsForOldAmount=$amountStudent->getAmountPayed();
						foreach($listPaymentsForOldAmount as $paye)
						{
							$paye->setAmount($updatedAmount);						
						}
					}					
				}
			}			
			
			$em->flush();

			if($origin != 1)
			{
				$session->getFlashBag()->add('creaStud', 'This student is updated !');
			}
			else
			{
				$session->getFlashBag()->add('creaStud', 'This student is added in the database !');				
			}

			return $this->redirectToRoute('admin_school_listAndCreate', 
				array('origin'=>1, 'id'=>0));
		}
		//				
		
		/*$payments=$em->getRepository('ArticleBundle:AmountPayed')->getAmountsPayedByStudentAndAmount($student->getId(), $amount->getId());
		var_dump($payments);die;*/
		$listStudents=[];
		if($listStudentsNotArchived)
		{
			foreach($listStudentsNotArchived as $student)
			{				
				//Sélection du montant à payer pour l'année civile en cours pour un étudiant
				//selon son année scolaire
				$amount=$student->getAmount();
				if($amount)
				{			
					$idStudent=$student->getId();
					$idAmount=$amount->getId();
					$amountToBePayed=$amount->getAmountToBePayed();
					$examsfees=$amount->getExamFees();
					$totalYearCost=$amountToBePayed+$examsfees;
					
					$payments=$em->getRepository('ArticleBundle:AmountPayed')->getAmountsPayedByStudentAndAmount($idStudent, $idAmount);
					
					$listPayments=[];
					$listPayesDone=[];
					foreach($payments as $payment)
					{
						$paye=$payment;
						$payeDone=$payment->getPayment();
						$listPayments[]=$paye;
						$listPayesDone[]=$payeDone;
					}

					$totalPayed=array_sum($listPayesDone);
					$listStudents[]=array($student, $amountToBePayed, $examsfees, $totalYearCost, $listPayments, $totalPayed);
				}				
				
			}			
		}																	

		return $this->render('AdminBundle:School:listAndCreate.html.twig', 
			array('year'=>$yearSchool,
				  'origin'=>$origin,
				  'listStudents'=>$listStudents,
				  'form'=>$form->createView()));		
	}



	public function deleteAction(Request $request, $idStudent)
	{
		$em=$this->getDoctrine()->getManager();
		$session=$request->getSession();

		if($idStudent)
		{
			$listStudents=$em->getRepository('ArticleBundle:Student')->findAll();
			$listIdStudents=[];
			foreach($listStudents as $student)
			{
				$id=$student->getId();
				$listIdStudents[]=$id;
			}
			if(in_array($idStudent, $listIdStudents))
			{
				$deletedStudent=$em->getRepository('ArticleBundle:Student')->find($idStudent);
				$em->remove($deletedStudent);
				$em->flush();

				$session->getFlashBag()->add('deleteStud', 'This student is deleted !');
				return $this->redirectToRoute('admin_school_listAndCreate', 
					array('origin'=>1, 'id'=>0));
			}
			else
			{
				throw new NotFoundHttpException("Student not found");
			}
		}
		else
		{
			throw new NotFoundHttpException("Student not found");
		}
	}

	public function archiveStudentAction(Request $request, $idStudent)
	{
		$em=$this->getDoctrine()->getManager();
		$session=$request->getSession();
		$listFees=$em->getRepository('ArticleBundle:Amount')->findAll();
		rsort($listFees);
		$scholarityFeesObject=array_shift($listFees);
		$scholarityFees=$scholarityFeesObject->getAmountToBePayed();

		if($idStudent)
		{
			$listStudents=$em->getRepository('ArticleBundle:Student')->findByArchived(1);
			$listIdStudents=[];
			foreach($listStudents as $stud)
			{
				$id=$stud->getId();
				$listIdStudents[]=$id;
			}

			if(in_array($idStudent, $listIdStudents))
			{
				$student=$em->getRepository('ArticleBundle:Student')->find($idStudent);

				$amountByStudent=$student->getAmount();
				$amountsPayed=$em->getRepository('ArticleBundle:AmountPayed')->getAmountsPayedByStudentAndAmount($student->getId(), $amountByStudent->getId());
				$amounts=[];
				foreach($amountsPayed as $paye)
				{
					$amountPayed=$paye->getPayment();
					$amounts[]=$amountPayed;
				}

				$amountFinalPayed=array_sum($amounts);

				if($scholarityFees == $amountFinalPayed || $amountFinalPayed > $scholarityFees)
				{	

					$archivedFees=new ArchivedFeesStudent();
					$archivedFees->setScolarYear($amountByStudent->getScholarYear());
					$archivedFees->setCivilYear($amountByStudent->getCivilYear());
					$archivedFees->setExamFees($amountByStudent->getExamFees());
					$archivedFees->setAmountToBePayed($amountByStudent->getAmountToBePayed());
					$archivedFees->setStudent($student);

					foreach($amountsPayed as $payment)
					{
						$archivedFees->addAmountPayed($payment);
					}

					$amountByStudent->removeStudent($student);
					$student->setAmount(null);
					$student->setArchived(2);
					$em->persist($archivedFees);
					$em->flush();

					$session->getFlashBag()->add('archive', $student->getFullName() . ' is archived !');
					return $this->redirectToRoute('admin_school_listAndCreate', ['origin'=>1,'id'=>0]);
				}
				else
				{
					$session->getFlashBag()->add('archive', $student->getFullName() . ' must pay more money !');
					return $this->redirectToRoute('admin_school_listAndCreate', ['origin'=>1,'id'=>0]);
				}
			}
			else
			{
				throw new NotFoundHttpException("Student not found");
			}
		}
		else
		{
			throw new NotFoundHttpException("Student not found");
		}
	}

	public function listArchivedStudentAction()
	{
		$em=$this->getDoctrine()->getManager();
		$listStudents=$em->getRepository('ArticleBundle:Student')->findByArchived(2);

		$listPaymentsByStudent=[];
		foreach($listStudents as $student)
		{
			$archivedFees=$student->getArchivedFees();			
			$listPaymentsByStudent[]=[$student, $archivedFees];
		}

		return $this->render('AdminBundle:School:listArchivedStudent.html.twig',
			array('listPaymentsByStudent'=>$listPaymentsByStudent));
	}
}

/*Récupération du montant des frais de scolarité les plus élevés (pour l'année en cours)
		$amounts=$em->getRepository('ArticleBundle:Amount')->findAll();
		rsort($amounts);
		$amountObject=array_shift($amounts);
		$amountYear=1;

		if($amountObject)
		{
			$amountYear=$amountObject->getAmountToBePayed();			
		}

		//Récupération de la liste des students, avec tableau vide créé pour recueillir les ids et montants déjà payés;
		$listStudents=$em->getRepository('ArticleBundle:Student')->findByArchived(1);
		$listStudentsWithPayments=[];
		foreach($listStudents as $student)		
		{
			$amountsPayed=$student->getAmountPayed();
			$listAmounts=[];
			foreach($amountsPayed as $amountPayed)
			{
				$amountOne=$amountPayed->getPayment();
				$listAmounts[]=$amountOne;
			}

			$amountsForOneStudent=array_sum($listAmounts);
			$listStudentsWithPayments[]=array($student, $amountsForOneStudent);
		}
/*var_dump($listStudentsWithPayments);die;
		$listIdStudents=[];
		/*

		//Instanciation d'un student
		if($origin == 1)
		{
			$student=new Student();			
		}
		else
		{
			foreach($listStudents as $stud)
			{
				$idStud=$stud->getId();
				$listIdStudents[]=$idStud;
			}

			if(in_array($id, $listIdStudents))
			{
				$student=$em->getRepository('ArticleBundle:Student')->find($id);
			}
			else
			{
				throw new NotFoundHttpException("Student not found");
			}
		}

		$form=$this->createForm(StudentType::class, $student);

		$form->handleRequest($request);
	
		if($form->isSubmitted() && $form->isValid())
		{
			$em->persist($student);
			$em->flush();

			if(in_array($id, $listIdStudents))
			{
				$session->getFlashBag()->add('creaStud', 'This student is updated !');
			}
			else
			{
				$session->getFlashBag()->add('creaStud', 'This student is added in the database !');				
			}

			return $this->redirectToRoute('admin_school_listAndCreate', 
				array('origin'=>1, 'id'=>0));
		}
		//		

		//Instanciation d'un amount (frais de scolarité sur l'année)
		$amounts=$em->getRepository('ArticleBundle:Amount')->findAll();
		if($amounts != null)
		{
			$affich=1;
			sort($amounts, SORT_NUMERIC);
			$amount=array_shift($amounts);			
		}
		else
		{
			$affich=2;
			$amount=new Amount();			
		}

		$formAmount=$this->createForm(AmountType::class, $amount);
		$formAmount->handleRequest($request);
		if($formAmount->isSubmitted() && $formAmount->isValid())
		{			
			$em->persist($amount);
			$em->flush();

			if($affich == 1)
			{
				$session->getFlashBag()->add('amount','This amount was successfully updated !');
			}
			else
			{
				$session->getFlashBag()->add('amountcreated','This amount was successfully created !');
			}
			return $this->redirectToRoute('admin_school_listAndCreate', 
				array('origin'=>1, 'id'=>0));		
		}
		*/