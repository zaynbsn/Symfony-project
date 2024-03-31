<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\Tag;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\TagType;

class HomepageController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $tagRepository = $entityManager->getRepository(Tag::class);

        // Fetch all tags
        $tags = $tagRepository->findAll();

        $tagsByType = [];
        foreach ($tags as $tag) {
            $type = $tag->getType();
            if ($type !== null) {
                $typeName = TagType::getName($type); // Get the name of the tag type
                $tagsByType[$typeName][] = $tag;
            }
        }

        // Get the selected tags from the request
        $selectedTags = $request->query->all();

        // Get the Event repository
        $eventRepository = $entityManager->getRepository(Event::class);

        // Initialize an associative array to store the events
        $events = [];

        // Fetch events based on the selected tags
        foreach ($selectedTags as $tagName => $tagId) {
            // Skip if the parameter is not a valid tag
            if (!is_numeric($tagId)) {
                continue;
            }

            // Fetch events based on the tag
            $eventsWithTag = $eventRepository->findByTag($tagId);
            // Merge the events into the main events array
            foreach ($eventsWithTag as $event) {
                // Use event ID as the key to avoid duplicates
                if (!isset($events[$event->getId()])) {
                    $events[$event->getId()] = [
                        'event' => $event,
                        'tagCount' => 1,
                    ];
                } else {
                    // Increment tag count if event already exists
                    $events[$event->getId()]['tagCount']++;
                }
            }
        }

        // Filter events to include only those with tag count equal to the number of selected tags
        $filteredEvents = array_filter($events, function ($event) use ($selectedTags) {
            return $event['tagCount'] == count($selectedTags);
        });

        // Extract events from filtered array
        $finalEvents = array_map(function ($event) {
            return $event['event'];
        }, $filteredEvents);

        // If no tags are selected, fetch all events
        if (empty($selectedTags)) {
            $finalEvents = $eventRepository->findAll();
        }

        return $this->render('homepage/index.html.twig', [
            'tags' => $tagsByType,
            'events' => array_values($finalEvents), // Convert associative array to indexed array
            'selectedTags' => $selectedTags,
        ]);
    }

}
