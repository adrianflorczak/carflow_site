<?php

namespace App\Controller\Api\v_0_0_1;

use App\Service\CarService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/v-0-0-1/organizations/{organizationId}/branches/{branchId}/cars')]
class CarController extends AbstractController
{
    private CarService $service;

    public function __construct(CarService $service)
    {
        $this->service = $service;
    }

    #[Route('', name: 'app_api_cars_create-new-car', methods: ['POST'])]
    public function createNewCar(Request $request, string $organizationId, string $branchId): Response
    {
        $payload = json_decode($request->getContent(), false);
        $car = [
            'brand' => $payload->brand,
            'model' => $payload->model,
            'vin' => $payload->vin,
            'segment' => $payload->segment,
            'bodyType' => $payload->bodyType,
            'color' => $payload->color,
            'fuel' => $payload->fuel,
            'numberOfSeats' => $payload->numberOfSeats,
            'numberOfDoors' => $payload->numberOfDoors,
            'registrationNumber' => $payload->registrationNumber,
             'technicalExaminationDate' => $payload->technicalExaminationDate,
            'insuranceExpirationDate' => $payload->insuranceExpirationDate,
            'mileage' => $payload->mileage,
        ];

        $this->service->createCarForBranchForCurrentlyLoggedUser(
            intval($organizationId),
            intval($branchId),
            $car
        );

        return $this->json(null, 201);
    }

    #[Route('', name: 'app_api_cars_get-cars', methods: ['GET'])]
    public function getCars(string $organizationId, string $branchId): Response
    {
        $cars = $this->service->getCarsFromBranchForCurrentlyLoggedUser(intval($organizationId), intval($branchId));

        return $this->json($cars);
    }


}