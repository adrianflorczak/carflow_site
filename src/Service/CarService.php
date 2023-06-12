<?php

namespace App\Service;

use App\Entity\Car;
use App\Repository\CarRepository;
use Symfony\Component\HttpKernel\Exception\HttpException;

class CarService
{

    private CarRepository $carRepository;

    public function __construct(CarRepository $carRepository)
    {
        $this->carRepository = $carRepository;
    }

    public function getCount(): int
    {
        return $this->carRepository->count([]);
    }

    public function saveCar(Car $car): Car
    {
        return $this->carRepository->save($car, true);
    }

    public function getCars(): array
    {
        return $this->carRepository->findAll();
    }

    public function getCar(int $id): Car
    {
        $car = $this->carRepository->findOneBy(['id' => $id]);

        if ($car) {
            return $car;
        } else {
            throw new HttpException(404, 'Not Found');
        }
    }

    public function removeCarById(int $id): void
    {
        $car = $this->carRepository->findOneBy(["id" => $id]);

        if ($car) {
            $this->carRepository->remove($car, true);
        } else {
            throw  new HttpException(404, 'Not Found');
        }
    }
}