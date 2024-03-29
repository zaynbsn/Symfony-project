<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\FakeData;

class FakeDataController extends AbstractController
{
    #[Route('/fake-data', name: 'fake_data')]
public function index(): Response
{
$users = FakeData::users();
$tags = FakeData::tags();
$events = FakeData::events();
$encounters = FakeData::encounters();

return $this->render('fake_data/index.html.twig', [
'users' => $users,
'tags' => $tags,
'events' => $events,
'encounters' => $encounters,
]);
}
}