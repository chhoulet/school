<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ArticleBundle\Entity\Amount;
use ArticleBundle\Form\AmountType;
use ArticleBundle\Form\YearType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AmountController extends Controller
{
	public function createAction(Request $request, $origin, $idAmount=null)
	{
		$em=$this->getDoctrine()->getManager();
		$session=$request->getSession();
		$affich=1;		
		$year= new \DateTime();
		$yearOf=$year->format('Y');
		$yearMore=$yearOf+1;
		$yearForChoice=$yearOf.'-'.$yearMore;			

		$amounts=$em->getRepository('ArticleBundle:Amount')->findAll();

		//Sélection de l'année civile des amounts (uniquement ceux de l'année en cours) 
		$listAmountsForYear=[];
		foreach($amounts as $price)
		{
			$yearAmount=$price->getCivilYear();
			if($yearAmount && $yearAmount == $yearForChoice)
			{
				$listAmountsForYear[]=$price;
			}
		}

		//Création form Amount et sélection de l'objet Amount
		if($origin == 1)
		{
			$amount=new Amount();			
		}
		else
		{
			$listAmounts=$em->getRepository('ArticleBundle:Amount')->findAll();
			$listIdAmounts=[];
			foreach($listAmounts as $amoun)
			{
				$id=$amoun->getId();
				$listIdAmounts[]=$id;
			}
			if($idAmount && in_array($idAmount, $listIdAmounts))
			{
				$affich=2;
				$amount=$em->getRepository('ArticleBundle:Amount')->find($idAmount);
			}
			else
			{
				throw new NotFoundHttpException("Year School not found");
			}
		}

		$formAmount=$this->createForm(AmountType::class, $amount);
		//

		$formAmount->handleRequest($request);

		if($formAmount->isSubmitted() && $formAmount->isValid())
		{
			$em->persist($amount);
			$em->flush();

			if($affich == 1)
			{
				$session->getFlashBag()->add('yearSchool', $amount->getScholarYear(). ' is added in the database !' );				
			}
			else
			{
				$session->getFlashBag()->add('yearSchool', $amount->getScholarYear(). ' is updated successfully !' );
			}
			return $this->redirectToRoute('admin_amount_create', 
				array('origin'=>1,
					  'idAmount'=>0));
		}

		return $this->render('AdminBundle:Amount:create.html.twig', 
			array('formAmount'    =>$formAmount->createView(),				 
				  'affich'        =>$affich,
				  'yearForChoice' =>$yearForChoice,			 
				  'amounts'       =>$listAmountsForYear));
	}

	public function deleteAction(Request $request, $idAmount)
	{
		$em=$this->getDoctrine()->getManager();
		$session=$request->getSession();		

		$listAmounts=$em->getRepository('ArticleBundle:Amount')->findAll();
		$listIdAmounts=[];
		foreach($listAmounts as $amoun)
		{
			$id=$amoun->getId();
			$listIdAmounts[]=$id;
		}
		if($idAmount && in_array($idAmount, $listIdAmounts))
		{			
			$amount=$em->getRepository('ArticleBundle:Amount')->find($idAmount);
			$em->remove($amount);
			$em->flush();

			$session->getFlashBag()->add('yearSchool', 'This year school is deleted !' );
			return $this->redirectToRoute('admin_amount_create', 
				array('origin'=>1,
					  'idYear'=>0));
		}
		else
		{
			throw new NotFoundHttpException("Amount not found");
		}
	}

	public function listAction(Request $request)
	{
		$em=$this->getDoctrine()->getManager();		
		$listAmounts=null;

		$form=$this->createForm(YearType::class);
		$form->handleRequest($request);

		if($form->isSubmitted() && $form->isValid())
		{
			$data=$form->getData();
			$yearAsked=$data['year'];
			$listAmounts=$em->getRepository('ArticleBundle:Amount')->getAmounts($yearAsked);
		}

		return $this->render('AdminBundle:Amount:list.html.twig', 
			array('form'       =>$form->createView(),
				  'listAmounts'=>$listAmounts));
	}
}
