<?php

namespace App\Controller;

use App\FakeData;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function index(): Response
    {
        $events = FakeData::events();
        $tags = FakeData::tags();
        return $this->render('homepage/index.html.twig', [
            'events' => $events,
            'tags' => $tags,
        ]);
    }

}
