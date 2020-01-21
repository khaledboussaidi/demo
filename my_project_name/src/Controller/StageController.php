<?php

namespace App\Controller;

use App\Entity\Entreprise;
use App\Entity\Stage;
use App\Form\AffecterStagerType;
use App\Form\RegistrationFormType;
use App\Form\StageFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class StageController extends AbstractController

{
    private $user;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->user = $tokenStorage->getToken()->getUser();
    }
    /**
     * @Route("/ajouterstage", name="ajouterstage")
     */
    public function AddStage(Request $request)
    {

        $stage=new Stage();
        $form=$this->createForm(StageFormType::class,$stage,[
            'action'=>$this->generateUrl('ajouterstage')
        ]);
        $form->handleRequest($request);
        if($form->isSubmitted()&&$form->isValid())
        {

            $em = $this->getDoctrine()->getManager();
            $this->user->addStage($stage);

            $em->persist($stage);
            $em->flush();
            return $this->render('stage/ajouterstage.html.twig', [
                'post_form' => $form->createView(),
            ]);


        }
        return $this->render('stage/ajouterstage.html.twig', [
            'post_form' => $form->createView(),
        ]);

    }

    /**
     * @Route("/ajouterstager/{id}", name="ajouterstager")
     */
    public function AddStager(Request $request,$id)
    {
        $em = $this->getDoctrine()->getManager();
        $stage=$em->getRepository(Stage::class)->find($id);
        $form=$this->createForm(AffecterStagerType::class,$stage,[
            'action'=>$this->generateUrl('ajouterstager',['id'=>$id])
        ]);
        $form->handleRequest($request);
        if($form->isSubmitted()&&$form->isValid())
        {
            $usr=$stage->getStager()[count($stage->getStager())-1];
            if($usr){
                $usr->setStage($stage);
                $em->persist($usr);
            }

            $em->flush();
            return $this->render('stage/ajouterstager.html.twig', [
                'post_form' => $form->createView(),
            ]);


        }
        return $this->render('stage/ajouterstager.html.twig', [
            'post_form' => $form->createView(),
        ]);

    }

    /**
     * @inheritDoc
     */
    public function getToken()
    {
        // TODO: Implement getToken() method.
    }

    /**
     * @inheritDoc
     */
    public function setToken(TokenInterface $token = null)
    {
        // TODO: Implement setToken() method.
    }
}
