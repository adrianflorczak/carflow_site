<?php

namespace App\Controller\Administrator;

use App\Entity\Car;
use App\Form\administrator\car\CarType;
use App\Form\administrator\car\helper\ConfirmationClass;
use App\Form\administrator\car\RemoveCarType;
use App\Repository\BranchRepository;
use App\Service\BranchService;
use App\Service\CarService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/administrator-panel/cars')]
class CarController extends AbstractController
{
    private CarService $carService;
    private BranchService $branchService;

    public function __construct(CarService $carService, BranchService $branchService)
    {
        $this->carService = $carService;
        $this->branchService = $branchService;
    }

    #[Route('', name: 'app_administrator_car_home', methods: ['GET'])]
    public function getHome(): Response
    {
        $counter = $this->carService->getCount();

        return $this->render('administrator/view/car/dashboard/index.html.twig', [
            'counter' => $counter
        ]);
    }

    #[Route('/show-all', name: 'app_administrator_car_show-all', methods: ['GET'])]
    public function getCars(): Response
    {
        $cars = $this->carService->getCars();

        return $this->render('administrator/view/car/showAll/index.html.twig', [
            'cars' => $cars
        ]);
    }

    #[Route('/{id}', name: 'app_administrator_car_show-car', methods: ['GET'])]
    public function getCar(string $id): Response
    {
        $car = $this->carService->getCar(intval($id));
        $branch = $car->getBranch();
        $organization = $branch->getOrganization();

        return $this->render('administrator/view/car/showOne/index.html.twig', [
            'branch' => $branch,
            'organization' => $organization,
            'car' => $car,
            'technicalExaminationDate' => $car->getTechnicalExaminationDate()->format('d-m-Y'),
            'insuranceExpirationDate' => $car->getInsuranceExpirationDate()->format('d-m-Y')
        ]);
    }

    #[Route('/{id}/update-car', name: 'app_administrator_car_update-car', methods: ['GET', 'POST'], priority: 10)]
    public function updateCar(string $id, Request $request): Response
    {
        $car = $this->carService->getCar(intval($id));

        $form = $this->createForm(CarType::class, $car);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $car->setBranch($data->getBranch());
            $car->setBrand($data->getBrand());
            $car->setModel($data->getModel());
            $car->setVin($data->getVin());
            $car->setSegment($data->getSegment());
            $car->setBodyType($data->getBodyType());
            $car->setColor($data->getColor());
            $car->setFuel($data->getFuel());
            $car->setNumberOfSeats($data->getNumberOfSeats());
            $car->setNumberOfDoors($data->getNumberOfDoors());
            $car->setRegistrationNumber($data->getRegistrationNumber());
            $car->setTechnicalExaminationDate($data->getTechnicalExaminationDate());
            $car->setInsuranceExpirationDate($data->getInsuranceExpirationDate());
            $car->setMileage($data->getMileage());


            try {
                $this->carService->saveCar($car);
                echo 'ok';
                $this->addFlash('new_car_success', 'Poprawnie zaktualizowano wartość');
            } catch (HttpException $e) {
                echo $e;
                $this->addFlash('new_car_error', 'Podczas aktualizacji wartości wystąpił błąd');
            } finally {
                return $this->redirectToRoute('app_administrator_car_show-all');
            }
        }

        return $this->render('administrator/view/car/update/index.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/create-new', name: 'app_administrator_car_create-new', methods: ['GET', 'POST'], priority: 10)]
    public function newCar(Request $request): Response
    {

        if(count($this->branchService->getBranches()))
        {
            $car = new Car();

            $form = $this->createForm(CarType::class, $car);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $data = $form->getData();
                $car->setBranch($data->getBranch());
                $car->setBrand($data->getBrand());
                $car->setModel($data->getModel());
                $car->setVin($data->getVin());
                $car->setSegment($data->getSegment());
                $car->setBodyType($data->getBodyType());
                $car->setColor($data->getColor());
                $car->setFuel($data->getFuel());
                $car->setNumberOfSeats($data->getNumberOfSeats());
                $car->setNumberOfDoors($data->getNumberOfDoors());
                $car->setRegistrationNumber($data->getRegistrationNumber());
                $car->setTechnicalExaminationDate($data->getTechnicalExaminationDate());
                $car->setInsuranceExpirationDate($data->getInsuranceExpirationDate());
                $car->setMileage($data->getMileage());


                try {
                    $this->carService->saveCar($car);
                    echo 'ok';
                    $this->addFlash('new_car_success', 'Poprawnie zapisano nową wartość');
                } catch (HttpException $e) {
                    echo $e;
                    $this->addFlash('new_car_error', 'Podczas zapisywania nowej wartości wystąpił błąd');
                } finally {
                    return $this->redirectToRoute('app_administrator_car_show-all');
                }
            }

            return $this->render('administrator/view/car/new/index.html.twig', [
                'form' => $form
            ]);
        } else {
            $this->addFlash('not_branch_in_car_error', 'Aby dodać nowy pojazd w systemie musi być zarejestrowany przynajmniej jeden oddział');
            return $this->redirectToRoute('app_administrator_car_show-all');
        }
    }

    #[Route('/{id}/remove-car', name: 'app_administrator_car_remove-car', methods: ['GET', 'POST'])]
    public function removeCar(string $id, Request $request): Response
    {
        $car = $this->carService->getCar(intval($id));
        $confirmation = new ConfirmationClass();

        $form = $this->createForm(RemoveCarType::class, $confirmation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            if ($data->getConfirmation())
            {
                try {
                    $this->carService->removeCarById(intval($id));
                    $this->addFlash('remove_car_success', 'Pojazd został poprawnie usunięty.');
                } catch (HttpException $e)
                {
                    $this->addFlash('remove_car_exception', 'Server Error');
                } finally {
                    return $this->redirectToRoute('app_administrator_car_show-all');
                }
            } else
            {
                $this->addFlash('confirmation_reject_error', 'Proces usówania pojazdu został przerwany przez użytkownika');
                return $this->redirectToRoute('app_administrator_car_show-all');
            }
        }

        return $this->render('administrator/view/car/delete/index.html.twig', [
            'car' => $car,
            'form' => $form
        ]);
    }
}