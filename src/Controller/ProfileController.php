<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\User;
use App\FakeData;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $eventsRepository = $entityManager->getRepository(Event::class);
        $events = $eventsRepository->findAll();

        return $this->render('profile/index.html.twig', [
            'user' => $user,
            'events' => $events
        ]);
    }

    #[Route('/profile/{id}', name: 'app_view_profile')]
    public function viewProfile($id, EntityManagerInterface $entityManager): Response
    {
        $repository = $entityManager->getRepository(User::class);
        $user = $repository->find($id);

        var_dump($user->getRoles());

        $events = FakeData::events(2);

        if (!$user) {
            throw $this->createNotFoundException('User not found');
        }

        // Render the profile template with user data
        return $this->render('profile/index.html.twig', [
            'user' => $user,
            'events' => $events
        ]);
    }
}
