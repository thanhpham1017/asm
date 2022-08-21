<?php

namespace App\Controller;

use App\Entity\Phone;
use App\Form\PhoneType;
use App\Repository\PhoneRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

use function PHPUnit\Framework\throwException;

#[Route('/phone')]
class PhoneController extends AbstractController
{
  #[IsGranted('ROLE_ADMIN')]
  #[Route('/index', name: 'phone_index')]
  public function phoneIndex (PhoneRepository $phoneRepository) {
    //$phones = $this->getDoctrine()->getRepository(Phone::class)->findAll();
    $phones = $phoneRepository->sortPhoneByIdDesc();
    return $this->render('phone/index.html.twig',
        [
            'phones' => $phones
        ]);
  }

  #[IsGranted('ROLE_CUSTOMER')]
  #[Route('/list', name: 'phone_list')]
  public function phoneList () {
    $phones = $this->getDoctrine()->getRepository(Phone::class)->findAll();
    $session = new Session();
    $session->set('search', false);
    return $this->render('phone/list.html.twig',
        [
            'phones' => $phones
        ]);
  }

  #[Route('/detail/{id}', name: 'phone_detail')]
  public function phoneDetail ($id, PhoneRepository $phoneRepository) {
    $phone = $phoneRepository->find($id);
    if ($phone == null) {
        $this->addFlash('Warning', 'Invalid phone id !');
        return $this->redirectToRoute('phone_index');
    }
    return $this->render('phone/detail.html.twig',
        [
            'phone' => $phone
        ]);
  }

  #[Route('/delete/{id}', name: 'phone_delete')]
  public function phoneDelete ($id, ManagerRegistry $managerRegistry) {
    $phone = $managerRegistry->getRepository(Phone::class)->find($id);
    if ($phone == null) {
        $this->addFlash('Warning', 'Phone not existed !');
    
    } else {
        $manager = $managerRegistry->getManager();
        $manager->remove($phone);
        $manager->flush();
        $this->addFlash('Info', 'Delete phone successfully !');
    }
    return $this->redirectToRoute('phone_index');
  }

  #[Route('/add', name: 'phone_add')]
  public function phoneAdd (Request $request) {
    $phone = new Phone;
    $form = $this->createForm(PhoneType::class,$phone);
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
        $manager = $this->getDoctrine()->getManager();
        $manager->persist($phone);
        $manager->flush();
        $this->addFlash('Info','Add phone successfully !');
        return $this->redirectToRoute('phone_index');
    }
    return $this->renderForm('phone/add.html.twig',
    [
        'phoneForm' => $form
    ]);
  }

  #[Route('/edit/{id}', name: 'phone_edit')]
  public function phoneEdit ($id, Request $request) {
    $phone = $this->getDoctrine()->getRepository(Phone::class)->find($id);
    if ($phone == null) {
        $this->addFlash('Warning', 'Phone not existed !');
        return $this->redirectToRoute('phone_index');
    } else {
        $form = $this->createForm(PhoneType::class,$phone);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($phone);
            $manager->flush();
            $this->addFlash('Info','Edit phone successfully !');
            return $this->redirectToRoute('phone_index');
        }
        return $this->renderForm('phone/edit.html.twig',
        [
            'phoneForm' => $form
        ]);
    }
  }

  #[IsGranted('ROLE_CUSTOMER')]
  #[Route('/price/asc', name: 'sort_price_ascending')]
  public function sortPriceAscending (PhoneRepository $phoneRepository) {
    $phones = $phoneRepository->sortPhonePriceAsc();
    return $this->render('phone/list.html.twig', 
    [
        'phones' => $phones
    ]);
  }

  #[IsGranted('ROLE_CUSTOMER')]
  #[Route('/price/desc', name: 'sort_price_descending')]
  public function sortPriceDescending (PhoneRepository $phoneRepository) {
    $phones = $phoneRepository->sortPhonePriceDesc();
    return $this->render('phone/list.html.twig', 
    [
        'phones' => $phones
    ]);
  }

  #[IsGranted('ROLE_CUSTOMER')]
  #[Route('/search', name: 'search_phone')]
  public function searchPhone(PhoneRepository $phoneRepository, Request $request) {
    $phones = $phoneRepository->searchPhone($request->get('keyword'));
    $session = $request->getSession();
    $session->set('search', true);
    return $this->render('phone/list.html.twig', 
    [
        'phones' => $phones,
    ]);
  }
}
