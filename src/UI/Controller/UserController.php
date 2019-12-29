<?php

namespace App\UI\Controller;

use App\UI\Form\RegistrationType;
use App\User\Application\Command\RegisterUserCommand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    private $messageBus;

    /**
     * DefaultController constructor.
     * @param $messageBus
     */
    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    /**
     * @Route("/register", methods="POST", name="register")
     * @param Request $request
     * @return Response
     */
    public function register(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $command =  new RegisterUserCommand();
        $form = $this->createForm(RegistrationType::class, $command);
        $form->submit($data);
        if (!$form->isValid()) {
            $errors = $this->getErrorsFromForm($form);
            return $this->json($errors, 400);
        }
        $this->messageBus->dispatch($command);
        return $this->json($command->getEmail(), 201);
    }

    protected function getErrorsFromForm(FormInterface $form)
    {
        $errors = [];
        foreach ($form->getErrors() as $error) {
            $errors[] = $error->getMessage();
        }
        foreach ($form->all() as $childForm) {
            if ($childForm instanceof FormInterface) {
                if ($childErrors = $this->getErrorsFromForm($childForm)) {
                    $errors[$childForm->getName()] = $childErrors;
                }
            }
        }
        return $errors;
    }
}