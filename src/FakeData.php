<?php

namespace App;

use App\Entity\User;
use App\Entity\Tag;
use App\Entity\Event;
use App\Entity\Encounter;
use App\Entity\TagType;

class FakeData
{
    public static function users($count = 10)
    {
        $users = [];
        for ($i = 1; $i <= $count; $i++) {
            $user = new User();
            $dateString = date("d/m/Y", rand(1, 100000) * 1000);
            $date = \DateTime::createFromFormat('d/m/Y', $dateString);

            $user->setLastname("Lastname_" . $i)
                ->setFirstname("Firstname_" . $i)
                ->setUsername("User_" . $i)
                ->setEmail("user$i@example.com")
                ->setBirthdate($date)
                ->setProfilepicture("https://fakeimg.pl/256x256/?text=User_" . $i);
            $users[] = $user;
        }
        return $users;
    }

    public static function tags($count = 25)
    {
        $tags = [];
        $tagTypes = TagType::values();
        for ($i = 1; $i <= $count; $i++) {
            $tag = new Tag();
            $tag->setName("Tag_" . $i)
                ->setImageurl("https://fakeimg.pl/256x256/?text=Tag_" . $i)
                ->setType($tagTypes[array_rand($tagTypes)]);
            $tags[] = $tag;
        }
        return $tags;
    }

    public static function events($count = 5)
    {
        $events = [];
        $encounters = self::encounters($count); // Generate encounters for each event

        for ($i = 1; $i <= $count; $i++) {
            $event = new Event();
            $startDate = new \DateTime();
            $startDate->setTimestamp(rand(time(), time() + 365 * 24 * 60 * 60));

            $description = self::generateRandomDescription();

            // Filter encounters for this event only if encounters are available
            if (!empty($encounters)) {
                $eventEncounters = array_filter($encounters, function ($encounter) {
                    return $encounter->getEvent();
                });
            } else {
                $eventEncounters = [];
            }

            $event
                ->setDescription($description)
                ->setStartdate($startDate)
                ->setMaximumcapacity(rand(10, 100))
                ->setAddress(self::generateRandomAddress())
                ->setReferent(self::users(1)[0]);

            // Add encounters to the event
            foreach ($eventEncounters as $encounter) {
                $event->addEncounter($encounter);
            }

            // Add attendees to the event
            $attendees = self::users(rand(5, 20)); // Generate random number of attendees
            foreach ($attendees as $attendee) {
                $event->addAttendy($attendee);
            }

            $events[] = $event;
        }
        return $events;
    }


    public static function encounters($count = 20)
    {
        $encounters = [];
        $teamTags = array_filter(self::tags(), function ($tag) {
            return $tag->getType() === TagType::Team;
        });

        if (empty($teamTags)) {
            // Handle the case when there are no team tags available
            // You may throw an exception, log an error, or take appropriate action
            return $encounters;
        }

        // Shuffle the team tags to ensure randomness
        shuffle($teamTags);

        // Select random team tags for encounters
        for ($i = 0; $i < $count; $i++) {
            $firstTeamTag = $teamTags[array_rand($teamTags)];
            $secondTeamTag = $teamTags[array_rand($teamTags)];
            $encounter = new Encounter();
            $encounter->setFirstteam($firstTeamTag)
                ->setSecondteam($secondTeamTag)
                ->setEvent(self::events(1)[0]);
            $encounters[] = $encounter;
        }

        return $encounters;
    }


    private static function generateRandomAddress()
    {
        $streets = ['Rue de la Liberté', 'Avenue des Champs-Élysées', 'Boulevard Haussmann', 'Rue du Faubourg Saint-Honoré', 'Rue de Rivoli'];

        $cities = ['Paris', 'Marseille', 'Lyon', 'Toulouse', 'Nice'];

        $departments = ['75', '13', '69', '31', '06'];

        $zipcode = sprintf("%05d", rand(10000, 99999)); // Ensure 5 digits with leading zeros if necessary
        $street = $streets[array_rand($streets)];
        $city = $cities[array_rand($cities)];
        $department = $departments[array_rand($departments)];
        return $street . ', ' . $zipcode . ' ' . $city . ' - ' . $department . ', France';
    }


    private static function generateRandomDescription()
    {
        $paragraphs = [
            "Lorem ipsum dolor sit amet, consectetur adipiscing elit.",
            "Integer sed neque finibus, tempus odio nec, molestie urna.",
            "Praesent aliquam dolor ac ultricies vestibulum.",
            "Suspendisse potenti. Sed vestibulum felis ac mi fermentum, sit amet pellentesque ex lobortis.",
            "Duis ac eros auctor, finibus odio vel, suscipit leo.",
            "Fusce convallis nunc sit amet nulla tincidunt, vel convallis ipsum gravida.",
            "Vivamus dignissim mauris et nunc euismod aliquet.",
            "Nam ut ligula non ex vestibulum ullamcorper.",
            "Vestibulum id mauris vel est venenatis fermentum.",
            "Sed efficitur risus vitae massa hendrerit dictum.",
            "Donec et tortor sit amet odio interdum venenatis a id mauris.",
            "Mauris eget metus nec libero pretium faucibus.",
            "Proin luctus enim non tellus pellentesque vehicula."
        ];

        $numParagraphs = rand(1, 5);

        $description = '';
        for ($i = 0; $i < $numParagraphs; $i++) {
            $index = array_rand($paragraphs);
            $description .= $paragraphs[$index] . " ";
        }

        return rtrim($description);
    }
}
