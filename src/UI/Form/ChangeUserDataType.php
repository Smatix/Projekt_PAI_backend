<?php

namespace App\UI\Form;

use App\User\Application\Command\ChangeUserDataCommand;
use App\User\Application\Service\UserService;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class ChangeUserDataType extends AbstractType
{
    /**
     * @var UserService
     */
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('newEmail', EmailType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a email',
                    ]),
                    new Email([
                        'message' => 'The email {{ value }} is not a valid email',
                    ]),
                    new Callback([
                        'callback' => [$this, 'checkEmail'],
                    ]),
                ],
            ])
            ->add('newPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options' => array('label' => false),
                'second_options' => array('label' => false),
                'invalid_message' => 'Password not match',
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ChangeUserDataCommand::class,
            'csrf_protection' => false
        ]);
    }

    public function checkEmail(?string $email, ExecutionContextInterface $context)
    {
        if ($email && $this->userService->checkIfEmailExist($email)) {
            $context->addViolation('Email exist.');
        }
    }
}