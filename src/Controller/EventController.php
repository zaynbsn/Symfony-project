<?php

namespace App\Controller;
use App\Entity\Event;
use App\FakeData;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EventController extends AbstractController
{
    #[Route('/event', name: 'event_list')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
//        $events = $entityManager->getRepository(Event::class)->findAll();
        $events = FakeData::events(10);
        return $this->render('event/index.html.twig', [
            'events' => $events,
        ]);
    }
    #[Route('/event/{id}', name: 'single_event')]
    public function show($id, EntityManagerInterface $entityManager): Response
    {
        // Fetch the event entity based on the provided ID
        $event = $this->getFakeEventById($id);

        // Check if the event exists
        if (!$event) {
            throw $this->createNotFoundException('Event not found');
        }

        // Render the template with the event data
        return $this->render('event/single.html.twig', [
            'event' => $event,
        ]);
    }


    private function getFakeEventById($id)
    {
        // Fetch all fake events
        $fakeEvents = FakeData::events();

        // Iterate through fake events to find the one with the matching ID
        foreach ($fakeEvents as $fakeEvent) {
            if ($fakeEvent->getId() == $id) {
                return $fakeEvent;
            }
        }

        // Return null if no event with the given ID is found
        return null;
    }
}


