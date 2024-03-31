<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\FakeData;

class FakeDataController extends AbstractController
{
    #[Route('/fake-data', name: 'fake_data')]
public function index(EntityManagerInterface $entityManager): Response
{
// Assuming $entityManager is your Doctrine EntityManager instance
        $fakeData = new FakeData($entityManager);
//$users = $fakeData->users();
//$tags = $fakeData->tags();
//$events = $fakeData->events();
//$encounters = $fakeData->encounters(10);

return $this->render('fake_data/index.html.twig', [
'users' => $users,
'tags' => $tags,
'events' => $events,
'encounters' => $encounters,
]);
}
}