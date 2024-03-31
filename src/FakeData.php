<?php

namespace App;

use App\Entity\LocationEnum;
use App\Entity\User;
use App\Entity\Tag;
use App\Entity\Event;
use App\Entity\Encounter;
use App\Entity\TagType;
use Doctrine\ORM\EntityManagerInterface;

class FakeData
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

//    public function users($count = 2)
//    {
//        $users = [];
//        $existingEmails = []; // Keep track of existing emails
//
//        for ($i = 1; $i <= $count; $i++) {
//            do {
//                $email = "user$i@example.com"; // Base email address
//                $uniqueIdentifier = uniqid(); // Generate a unique identifier
//                $emailWithUniqueId = $email . "_" . $uniqueIdentifier; // Append unique identifier to email
//
//                // Check if email already exists
//                $emailExists = in_array($emailWithUniqueId, $existingEmails);
//            } while ($emailExists); // Repeat until a unique email is generated
//
//            // Add the unique email to the list of existing emails
//            $existingEmails[] = $emailWithUniqueId;
//
//            // Create the user with the unique email
//            $user = new User();
//            // Populate other user data with random values
//            $user->setEmail($emailWithUniqueId);
//            $user->setRoles(['ROLE_USER']);
//            $user->setPassword('hashed_password'); // You may want to generate a random hashed password
//            $user->setLastname($this->generateRandomName());
//            $user->setFirstname($this->generateRandomName());
//            $user->setUsername($this->generateRandomUsername());
//            $user->setBirthdate($this->generateRandomBirthdate());
//            $user->setProfilepicture($this->generateRandomProfilePicture());
//
//            // Persist user entity...
//            $this->entityManager->persist($user);
//            $users[] = $user;
//        }
//
//        $this->entityManager->flush();
//        return $users;
//    }


//    public function tags($count = 20)
//    {
//        $tags = [];
//        $tagTypes = TagType::values();
//        for ($i = 1; $i <= $count; $i++) {
//            $tag = new Tag();
//            $tag->setName("Tag_" . $i)
//                ->setImageurl("https://fakeimg.pl/256x256/?text=Tag_" . $i)
//                ->setType($tagTypes[array_rand($tagTypes)]);
//            $this->entityManager->persist($tag);
//            $tags[] = $tag;
//        }
//        $this->entityManager->flush();
//        return $tags;
//    }

    public function events($count = 10)
    {
        $events = [];

        // Fetch existing users from the database
        $users = $this->entityManager->getRepository(User::class)->findAll();

        for ($i = 1; $i <= $count; $i++) {
            $event = new Event();
            $startDate = new \DateTime();
            $startDate->setTimestamp(rand(time(), time() + 365 * 24 * 60 * 60));

            $description = $this->generateRandomDescription();

            $locationValues = LocationEnum::values();

            $randomLocation = $locationValues[array_rand($locationValues)];

            $event->setLocation($randomLocation);

            $event
                ->setDescription($description)
                ->setStartdate($startDate)
                ->setMaximumcapacity(rand(10, 100))
                ->setAddress($this->generateRandomAddress())
                ->setLocation($randomLocation);

            // Set a referent for the event
            if (!empty($users)) {
                $referent = $users[array_rand($users)]; // Pick a random user from existing users
                $event->setReferent($referent);
            }



            // Add attendees to the event (assuming you still want to generate attendees)
            $attendees = $this->generateRandomAttendees($users, rand(5, 20));
            foreach ($attendees as $attendee) {
                $event->addAttendy($attendee);
            }

            $this->entityManager->persist($event);
            $events[] = $event;
        }

        $this->entityManager->flush();
        return $events;
    }


    public function encounters($count = 1)
    {
        $encounters = [];
        $teamTags = $this->entityManager->getRepository(Tag::class)->findBy(['type' => TagType::Team]);

        if (empty($teamTags)) {
            // Handle the case when there are no team tags available
            return $encounters;
        }

        // Fetch existing events from the database
        $events = $this->entityManager->getRepository(Event::class)->findAll();

        // Fetch existing tags from the database
        $tags = $this->entityManager->getRepository(Tag::class)->findAll();

        // Select random events and tags for encounters
        for ($i = 0; $i < $count; $i++) {
            $event = $events[array_rand($events)];

            $firstTeamTag = $teamTags[array_rand($teamTags)];
            $secondTeamTag = $teamTags[array_rand($teamTags)];
            $encounter = new Encounter();
            $encounter->setEvent($event)
                ->setFirstteam($firstTeamTag)
                ->setSecondteam($secondTeamTag);

            $numTags = rand(1, 10);
            $selectedTags = array_slice($tags, 0, $numTags);
            foreach ($selectedTags as $tag) {
                $encounter->addTag($tag);
            }
            $this->entityManager->persist($encounter);
            $encounters[] = $encounter;
        }

        $this->entityManager->flush();
        return $encounters;
    }



    private function generateRandomAddress()
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


    private function generateRandomDescription()
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


    private function generateRandomName()
    {
        $firstNames = ['John', 'Jane', 'Alice', 'Bob', 'Michael'];
        $lastNames = ['Doe', 'Smith', 'Johnson', 'Brown', 'Taylor'];

        $firstName = $firstNames[array_rand($firstNames)];
        $lastName = $lastNames[array_rand($lastNames)];

        return $firstName . ' ' . $lastName;
    }

    private function generateRandomUsername()
    {
        $usernames = ['user123', 'john_doe', 'alice_smith', 'michael123', 'janedoe'];

        return $usernames[array_rand($usernames)];
    }

    private function generateRandomBirthdate()
    {
        $startDate = new \DateTime('1950-01-01');
        $endDate = new \DateTime('2000-12-31');
        $randomTimestamp = mt_rand($startDate->getTimestamp(), $endDate->getTimestamp());

        $randomDate = new \DateTime();
        $randomDate->setTimestamp($randomTimestamp);

        return $randomDate;
    }

    private function generateRandomProfilePicture()
    {
        // Generate a random URL for the profile picture
        return 'https://example.com/profile_pictures/' . uniqid();
    }
    private function generateRandomAttendees(array $users, int $count): array
    {
        $attendees = [];

        // Shuffle the array of users to randomize the selection
        shuffle($users);

        // Select a random subset of users as attendees
        $attendees = array_slice($users, 0, $count);

        return $attendees;
    }

}
