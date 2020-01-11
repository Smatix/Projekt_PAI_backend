<?php

namespace App\UI\Form;

use App\Opinion\Application\Command\CreateOpinionCommand;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class OpinionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('rate', NumberType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a rate',
                    ]),
                ],
            ])
            ->add('comment', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a comment',
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
            'data_class' => CreateOpinionCommand::class,
            'csrf_protection' => false
        ]);
    }
}