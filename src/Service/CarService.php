<?php

namespace App\Service;

use App\Repository\CarRepository;

class CarService
{

    private CarRepository $carRepository;

    public function __construct(CarRepository $carRepository)
    {
        $this->carRepository = $carRepository;
    }

    public function getCars(): array
    {
        return $this->carRepository->findAll();
    }
}