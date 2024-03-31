<?php

namespace App\Form;

use App\Entity\Encounter;
use App\Entity\Event;
use App\Entity\LocationEnum;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends AbstractType
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('description', null, [
                'data' => 'Default description', // Default description if no value is provided
            ])
            ->add('startdate', null, [
                'widget' => 'single_text',
                'data' => new \DateTime(), // Default start date set to current date and time
            ])
            ->add('location', ChoiceType::class, [
                'choices' => LocationEnum::values(),
                'data' => LocationEnum::Annecy, // Default location
            ])
            ->add('maximumcapacity', null, [
                'data' => 10, // Default maximum capacity set to 10
            ])
            ->add('address', null, [
                'data' => 'Default address', // Default address if no value is provided
            ])
            ->add('encounters', EntityType::class, [
                'class' => Encounter::class,
                'choice_label' => 'description',
                'multiple' => true,
                'expanded' => true,
                'by_reference' => false, // Ensure that changes in encounters are detected
            ])
            ->add('attendies', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'username',
                'multiple' => true,
                'expanded' => true,
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
