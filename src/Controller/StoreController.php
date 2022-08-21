<?php

namespace App\Controller;

use App\Entity\Store;
use App\Form\StoreType;
use App\Repository\StoreRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/store')]
class StoreController extends AbstractController
{ 
    #[Route('/index', name: 'store_index')]
    public function storeIndex () {
      $stores = $this->getDoctrine()->getRepository(Store::class)->findAll();
      return $this->render('store/index.html.twig',
          [
              'stores' => $stores
          ]);
    }

    #[Route('/list', name: 'store_list')]
    public function storeList () {
      $stores = $this->getDoctrine()->getRepository(Store::class)->findAll();
      return $this->render('store/list.html.twig',
          [
              'stores' => $stores
          ]);
    }
  
    #[Route('/detail/{id}', name: 'store_detail')]
    public function storeDetail ($id, StoreRepository $storeRepository) {
      $store = $storeRepository->find($id);
      if ($store == null) {
          $this->addFlash('Warning', 'Invalid store id !');
          return $this->redirectToRoute('store_index');
      }
      return $this->render('store/detail.html.twig',
          [
              'store' => $store
          ]);
    }
  
    #[IsGranted("ROLE_ADMIN")]
    #[Route('/delete/{id}', name: 'store_delete')]
    public function storeDelete ($id, ManagerRegistry $managerRegistry) {
      $store = $managerRegistry->getRepository(Store::class)->find($id);
      if ($store == null) {
          $this->addFlash('Warning', 'Store not existed !');
      } 
      else if (count($store->getPhones()) > 0) {
        $this->addFlash('Warning', 'Can not delete this store !');
      } 
      else {
          $manager = $managerRegistry->getManager();
          $manager->remove($store);
          $manager->flush();
          $this->addFlash('Info', 'Delete store successfully !');
      }
      return $this->redirectToRoute('store_index');
    }
  
    #[Route('/add', name: 'store_add')]
    public function storeAdd (Request $request) {
      $store = new Store;
      $form = $this->createForm(StoreType::class,$store);
      $form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid()) {
          $manager = $this->getDoctrine()->getManager();
          $manager->persist($store);
          $manager->flush();
          $this->addFlash('Info','Add store successfully !');
          return $this->redirectToRoute('store_index');
      }
      return $this->renderForm('store/add.html.twig',
      [
          'storeForm' => $form
      ]);
    }
  
    #[Route('/edit/{id}', name: 'store_edit')]
    public function storeEdit ($id, Request $request) {
      $store = $this->getDoctrine()->getRepository(Store::class)->find($id);
      if ($store == null) {
          $this->addFlash('Warning', 'Store not existed !');
          return $this->redirectToRoute('store_index');
      } else {
          $form = $this->createForm(StoreType::class,$store);
          $form->handleRequest($request);
          if ($form->isSubmitted() && $form->isValid()) {
              $manager = $this->getDoctrine()->getManager();
              $manager->persist($store);
              $manager->flush();
              $this->addFlash('Info','Edit store successfully !');
              return $this->redirectToRoute('store_index');
          }
          return $this->renderForm('store/edit.html.twig',
          [
              'storeForm' => $form
          ]);
      }
    }
}

