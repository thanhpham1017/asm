<?php

namespace App\Controller;

use App\Entity\Producer;
use App\Form\ProducerType;
use App\Repository\ProducerRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/producer')]
class ProducerController extends AbstractController
{
  #[Route('/index', name: 'producer_index')]
  public function producerIndex () {
    $producers = $this->getDoctrine()->getRepository(Producer::class)->findAll();
    return $this->render('producer/index.html.twig',
        [
            'producers' => $producers
        ]);
  }

  #[Route('/list', name: 'producer_list')]
  public function producerList () {
    $producers = $this->getDoctrine()->getRepository(Producer::class)->findAll();
    return $this->render('producer/list.html.twig',
        [
            'producers' => $producers
        ]);
  }

  #[Route('/detail/{id}', name: 'producer_detail')]
  public function producerDetail ($id, ProducerRepository $producerRepository) {
    $producer = $producerRepository->find($id);
    if ($producer == null) {
        $this->addFlash('Warning', 'Invalid producer id !');
        return $this->redirectToRoute('producer_index');
    }
    return $this->render('producer/detail.html.twig',
        [
            'producer' => $producer
        ]);
  }

  #[Route('/delete/{id}', name: 'producer_delete')]
  public function producerDelete ($id, ManagerRegistry $managerRegistry) {
    $producer = $managerRegistry->getRepository(Producer::class)->find($id);
    if ($producer == null) {
        $this->addFlash('Warning', 'Producer not existed !');
    
    } else {
        $manager = $managerRegistry->getManager();
        $manager->remove($producer);
        $manager->flush();
        $this->addFlash('Info', 'Delete producer successfully !');
    }
    return $this->redirectToRoute('producer_index');
  }

  #[Route('/add', name: 'producer_add')]
  public function producerAdd (Request $request) {
    $producer = new Producer;
    $form = $this->createForm(ProducerType::class,$producer);
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
        $manager = $this->getDoctrine()->getManager();
        $manager->persist($producer);
        $manager->flush();
        $this->addFlash('Info','Add producer successfully !');
        return $this->redirectToRoute('producer_index');
    }
    return $this->renderForm('producer/add.html.twig',
    [
        'producerForm' => $form
    ]);
  }

  #[Route('/edit/{id}', name: 'producer_edit')]
  public function producerEdit ($id, Request $request) {
    $producer = $this->getDoctrine()->getRepository(Producer::class)->find($id);
    if ($producer == null) {
        $this->addFlash('Warning', 'Producer not existed !');
        return $this->redirectToRoute('producer_index');
    } else {
        $form = $this->createForm(ProducerType::class,$producer);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($producer);
            $manager->flush();
            $this->addFlash('Info','Edit producer successfully !');
            return $this->redirectToRoute('producer_index');
        }
        return $this->renderForm('producer/edit.html.twig',
        [
            'producerForm' => $form
        ]);
    }
  }
}
