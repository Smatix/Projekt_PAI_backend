<?php

namespace App\UI\Controller;

use App\UI\Form\ChangeUserDataType;
use App\UI\Form\RegistrationType;
use App\User\Application\Command\ChangeUserDataCommand;
use App\User\Application\Command\RegisterUserCommand;
use App\User\Application\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @var MessageBusInterface
     */
    private $messageBus;

    /**
     * @var UserService
     */
    private $userService;

    /**
     * UserController constructor.
     * @param MessageBusInterface $messageBus
     * @param UserService $userService
     */
    public function __construct(MessageBusInterface $messageBus, UserService $userService)
    {
        $this->messageBus = $messageBus;
        $this->userService = $userService;
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

    /**
     * @Route("/api/user/change_data", methods="PATCH", name="change_user_data")
     * @param Request $request
     * @return Response
     */
    public function changeData(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $currentEmail = $this->getUser()->getEmail();
        if (!$this->userService->checkIfPasswordIsCorrect($currentEmail, $data['oldPassword'])) {
            return $this->json(['oldPassword' => 'The password is not the same'], 400);
        }
        $command =  new ChangeUserDataCommand();
        $command->setOldEmail($currentEmail);
        $command->setOldPassword($data['oldPassword']);

        $form = $this->createForm(ChangeUserDataType::class, $command);
        $form->submit($data);
        if (!$form->isValid()) {
            $errors = $this->getErrorsFromForm($form);
            var_dump($errors);
            return $this->json($errors, 400);
        }
        $this->messageBus->dispatch($command);
        return $this->json($command->getNewEmail(), 201);
    }

    /**
     * @Route("api/user/data", methods="GET", name="get_user_data")
     * @return JsonResponse
     */
    public function getUserData()
    {
        $userData = [
            'name' => $this->getUser()->getName(),
            'surname' => $this->getUser()->getSurname(),
            'email' => $this->getUser()->getEmail(),
        ];
        return $this->json($userData);
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