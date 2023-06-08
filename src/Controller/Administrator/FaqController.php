<?php

namespace App\Controller\Administrator;

use App\Dto\Administrator\Faq\DeletionConfirmationDto;
use App\Dto\Administrator\Faq\FaqItemDto;
use App\Entity\Faq;
use App\Service\FaqService;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/administrator-panel/faq')]
class FaqController extends AbstractController
{
    private FaqService $faqService;

    public function __construct(FaqService $faqService)
    {
        $this->faqService = $faqService;
    }

    #[Route('', name: 'app_administrator_faq_home', methods: ['GET'])]
    public function getFaqDashboard(): Response
    {
        $counter = $this->faqService->getCount();
        return $this->render('administrator/view/faq/view/dashboard/index.html.twig', [
            'counter' => $counter
        ]);
    }

    #[Route('/create-new', name: 'app_administrator_faq_create-new', methods: ['GET', 'POST'])]
    public function createNewFaqItem(Request $request): Response
    {
        $item = new FaqItemDto();

        $form = $this->createFormBuilder($item)
            ->add('priority', IntegerType::class, [
                'label' => 'Priorytet',
                'attr' => [
                    'placeholder' => 'Priorytet',
                    'style' => 'margin: 15px;',
                    'min'=> 0
                ]
            ])
            ->add('question', TextType::class, [
                'label' => 'Pytanie',
                'attr' => [
                    'placeholder' => 'Tutaj wpisz treść pytania.',
                    'style' => 'margin: 15px;',
                ]
            ])
            ->add('answer', TextType::class, [
                'label' => 'Odpowiedź',
                'attr' => [
                    'placeholder' => 'Tutaj wpisz treść odpopwiedzi.',
                    'style' => 'margin: 15px;',
                ]
            ])
            ->add('saveButton', SubmitType::class, [
                'label' => 'Zapisz',
                'attr' => [
                    'class' => 'btn btn-success'
                ]
            ])
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $data = $form->getData();

            $faq = new Faq();
            $faq->setPriority($data->priority);
            $faq->setQuestion($data->question);
            $faq->setAnswer($data->answer);
            try {
                $this->faqService->saveFaqItem($faq);
                $this->addFlash('new_faq_item_success', 'Poprawnie zapisano nową wartość');
            } catch (HttpException $e) {
                $this->addFlash('new_faq_item_error', 'Podczas zapisywania nowej wartości wystąpił błąd');
            } finally {
                return $this->redirectToRoute('app_administrator_faq_show-all');
            }
        }

        return $this->render('administrator/view/faq/view/new/index.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/show-all', name: 'app_administrator_faq_show-all', methods: ['GET'])]
    public function getAllFaqItems(): Response {
        $faqs = $this->faqService->getAllFaqs();
        return $this->render('administrator/view/faq/view/showAll/index.html.twig', [
            'faqs' => $faqs
        ]);
    }

    #[Route('/{id}/edit', name: 'app_administrator_faq_update', methods: ['GET', 'POST'])]
    public function updateOneFaqItemById(string $id, Request $request): Response
    {
        $item = new FaqItemDto();

        $updateValue = $this->faqService->getItemById(intval($id));

        $form = $this->createFormBuilder($item)
            ->add('priority', IntegerType::class, [
                'label' => 'Priorytet',
                'attr' => [
                    'placeholder' => 'Priorytet.',
                    'min'=> 0,
                    'value' => $updateValue->getPriority(),
                    'style' => 'margin: 15px;',
                ]
            ])
            ->add('question', TextType::class, [
                'label' => 'Pytanie',
                'attr' => [
                    'placeholder' => 'Tutaj wpisz treść pytania.',
                    'value' => $updateValue->getQuestion(),
                    'style' => 'margin: 15px;',
                ]
            ])
            ->add('answer', TextType::class, [
                'label' => 'Odpowiedź',
                'attr' => [
                    'placeholder' => 'Tutaj wpisz treść odpopwiedzi.',
                    'value' => $updateValue->getAnswer(),
                    'style' => 'margin: 15px;',
                ]
            ])
            ->add('saveButton', SubmitType::class, [
                'label' => 'Zapisz',
                'attr' => [
                    'class' => 'btn btn-success'
                ]
            ])
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $data = $form->getData();

            $updateValue->setPriority($data->priority);
            $updateValue->setQuestion($data->question);
            $updateValue->setAnswer($data->answer);

            try {
                $this->faqService->saveFaqItem($updateValue);
                $this->addFlash('update_faq_item_success', 'Poprawnie zaktualizowano nową wartość');
            } catch (HttpException $e) {
                $this->addFlash('update_faq_item_error', 'Podczas aktualizacji wartości wystąpił błąd');
            } finally {
                return $this->redirectToRoute('app_administrator_faq_show-all');
            }
        }


        return $this->render('administrator/view/faq/view/update/index.html.twig', [
            'form' => $form,
            'id' => $id
        ]);
    }

    #[Route('/{id}/delete', name: 'app_administrator_faq_delete', methods: ['GET', 'POST'])]
    public function deleteOneFaqItem(string $id, Request $request): Response
    {
        $confirmation = new DeletionConfirmationDto();

        $form = $this->createFormBuilder($confirmation)
            ->add('confirmationText', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Czy chcesz usunąć wpis ?',
                    'style' => 'text-align: center;'
                ]
            ])
            ->add('confirmationButton', SubmitType::class, [
                'label' => 'POTWIERDŹ',
                'attr' => [
                    'style' => 'color: red; margin: 15px 0;',
                ]
            ])
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $data = $form->getData();

            if ($data->confirmationText == 'TAK')
            {
                try {
                    $this->faqService->removeItemById(intval($id));
                    $this->addFlash('remove_faq_item_success', 'Wartość usunięta poprawnie');
                    return $this->redirectToRoute('app_administrator_faq_show-all');
                } catch (HttpException $exception) {
                    $this->addFlash('remove_faq_item_error', 'Podczas usówania wartości wystąpił błąd');
                    return $this->redirectToRoute('app_administrator_faq_show-all');
                }
            } else
            {
                $this->addFlash(
                    'remove_faq_item_confirmation_error',
                    'Nie wpisno poprawnie tekstu potwierdzającego usunięcie zasobu.'
                );
                return $this->redirectToRoute('app_administrator_faq_delete', ['id' => $id]);
            }
        }

        $item = $this->faqService->getItemById(intval($id));

        return $this->render('administrator/view/faq/view/delete/index.html.twig', [
            'item' => $item,
            'form' => $form
        ]);
    }
}