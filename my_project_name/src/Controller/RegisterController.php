<?php

namespace App\Controller;

use App\Entity\Entreprise;
use App\Entity\Stager;
use App\Form\EntrepriseRegistrationFormType;

use App\Form\StagerRegistrationFormType;
use App\Repository\StagerRepository;
use mysql_xdevapi\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegisterController extends AbstractController
{
    private $encoder;
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder=$encoder;
    }


    /**
     * @Route("/stagerregister", name="stagerregister")
     */
    public function stagerregister(Request $request)
    {

        $error=null;
        $stager=new Stager();
        $form=$this->createForm(StagerRegistrationFormType::class,$stager,[
            'action'=>$this->generateUrl('stagerregister')
        ]);
        $form->handleRequest($request);
        if($form->isSubmitted()&&$form->isValid()){

            $em=$this->getDoctrine()->getManager();
            if(!$em->getRepository(Stager::class)->findOneBy(['username'=>$stager->getUsername()])&& !$em->getRepository(Stager::class)->findOneBy(['email'=>$stager->getEmail()]))
            {
                $stager->setPassword($this->encoder->encodePassword($stager,$stager->getPassword()));
                $em->persist($stager);
                $em->flush();



                return $this->render('register/stagerregister.html.twig', [
                    'post_form' => $form->createView(),'error' => $error,
                ]);}

            else{
                $error='username or email exist!!';
                return $this->render('register/stagerregister.html.twig', [
                    'post_form' => $form->createView(),'error' => $error,
                ]);
            }
        }
        return $this->render('register/stagerregister.html.twig', [
            'post_form' => $form->createView(),'error' => $error,
        ]);

    }



    /**
     * @Route("/entrepriseregister", name="enterpriseregister")
     */
    public function entrepriseregister(Request $request)
    {   $error=null;
        $entreprise=new Entreprise();
        $form=$this->createForm(EntrepriseRegistrationFormType::class,$entreprise,[
            'action'=>$this->generateUrl('enterpriseregister')
        ]);
        $form->handleRequest($request);
        if($form->isSubmitted()&&$form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            if (!$em->getRepository(Entreprise::class)->findOneBy(['username' => $entreprise->getUsername()]) && !$em->getRepository(Entreprise::class)->findOneBy(['email' => $entreprise->getEmail()]))
            {
                $entreprise->setPassword($this->encoder->encodePassword($entreprise, $entreprise->getPassword()));
                $em->persist($entreprise);
                $em->flush();
                return $this->render('register/entrepriseregister.html.twig', [
                    'post_form' => $form->createView(),'error' => $error
                ]);
            }
            else
            {
                $error = 'username or email exist!!';
                return $this->render('register/entrepriseregister.html.twig', [
                    'post_form' => $form->createView(), 'error' => $error,]);
            }

        }
        return $this->render('register/entrepriseregister.html.twig', [
            'post_form' => $form->createView(), 'error' => $error,]);

    }

}
