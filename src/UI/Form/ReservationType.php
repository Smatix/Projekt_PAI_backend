<?php

namespace App\UI\Form;

use App\Reservation\Application\Command\Create\CreateReservationCommand;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('reservationDate', DateType::class, [
                'widget' => 'single_text',
                'input'  => 'string',
            ])
            ->add('type', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a type',
                    ]),
                ],
            ])
            ->add('parkingId', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a parking',
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CreateReservationCommand::class,
            'csrf_protection' => false
        ]);
    }
}