<?php

namespace App\UI\Controller;

use App\Opinion\Application\Command\CreateOpinionCommand;
use App\UI\Form\OpinionType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class OpinionController extends AbstractController
{
    /**
     * @var MessageBusInterface
     */
    private $messageBus;

    /**
     * OpinionController constructor.
     * @param MessageBusInterface $messageBus
     */
    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    /**
     * @Route("/api/opinions", methods="POST", name="add_opinion")
     * @param Request $request
     * @return JsonResponse
     */
    public function addOpinion(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $command = new CreateOpinionCommand();
        $form = $this->createForm(OpinionType::class, $command);
        $form->submit($data);
        if (!$form->isValid()) {
            $errors = $this->getErrorsFromForm($form);
            return $this->json($errors, 400);
        }
        $command->setAuthor($this->getUser()->getId());
        $this->messageBus->dispatch($command);
        return $this->json($command->getId(), 201);
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