<?php

namespace App\Controller;

use App\Entity\Color;
use App\Form\ColorType;
use App\Repository\ColorRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/color')]
class ColorController extends AbstractController
{ 
    #[Route('/index', name: 'color_index')]
    public function colorIndex () {
      $colors = $this->getDoctrine()->getRepository(Color::class)->findAll();
      return $this->render('color/index.html.twig',
          [
              'colors' => $colors
          ]);
    }

    #[Route('/list', name: 'color_list')]
    public function colorList () {
      $colors = $this->getDoctrine()->getRepository(Color::class)->findAll();
      return $this->render('color/list.html.twig',
          [
              'colors' => $colors
          ]);
    }
  
    #[Route('/detail/{id}', name: 'color_detail')]
    public function colorDetail ($id, ColorRepository $colorRepository) {
      $color = $colorRepository->find($id);
      if ($color == null) {
          $this->addFlash('Warning', 'Invalid color id !');
          return $this->redirectToRoute('color_index');
      }
      return $this->render('color/detail.html.twig',
          [
              'color' => $color
          ]);
    }
  
    #[IsGranted("ROLE_ADMIN")]
    #[Route('/delete/{id}', name: 'color_delete')]
    public function colorDelete ($id, ManagerRegistry $managerRegistry) {
      $color = $managerRegistry->getRepository(Color::class)->find($id);
      if ($color == null) {
          $this->addFlash('Warning', 'Color not existed !');
      } 
      else if (count($color->getPhones()) > 0) {
        $this->addFlash('Warning', 'Can not delete this color !');
      } 
      else {
          $manager = $managerRegistry->getManager();
          $manager->remove($color);
          $manager->flush();
          $this->addFlash('Info', 'Delete color successfully !');
      }
      return $this->redirectToRoute('color_index');
    }
  
    #[Route('/add', name: 'color_add')]
    public function colorAdd (Request $request) {
      $color = new Color;
      $form = $this->createForm(ColorType::class,$color);
      $form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid()) {
          $manager = $this->getDoctrine()->getManager();
          $manager->persist($color);
          $manager->flush();
          $this->addFlash('Info','Add color successfully !');
          return $this->redirectToRoute('color_index');
      }
      return $this->renderForm('color/add.html.twig',
      [
          'colorForm' => $form
      ]);
    }
  
    #[Route('/edit/{id}', name: 'color_edit')]
    public function colorEdit ($id, Request $request) {
      $color = $this->getDoctrine()->getRepository(Color::class)->find($id);
      if ($color == null) {
          $this->addFlash('Warning', 'Color not existed !');
          return $this->redirectToRoute('color_index');
      } else {
          $form = $this->createForm(ColorType::class,$color);
          $form->handleRequest($request);
          if ($form->isSubmitted() && $form->isValid()) {
              $manager = $this->getDoctrine()->getManager();
              $manager->persist($color);
              $manager->flush();
              $this->addFlash('Info','Edit color successfully !');
              return $this->redirectToRoute('color_index');
          }
          return $this->renderForm('color/edit.html.twig',
          [
              'colorForm' => $form
          ]);
      }
    }
}
