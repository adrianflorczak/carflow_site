<?php

namespace App\Service;

use App\Entity\Car;
use App\Repository\BranchRepository;
use App\Repository\CarRepository;
use App\Repository\OrganizationRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpKernel\Exception\HttpException;

class CarService
{
    private OrganizationRepository $organizationRepository;
    private CarRepository $carRepository;
    private Security $security;

    public function __construct(
        OrganizationRepository $organizationRepository,
        CarRepository          $carRepository,
        Security               $security
    )
    {
        $this->organizationRepository = $organizationRepository;
        $this->carRepository = $carRepository;
        $this->security = $security;
    }

    public function createCarForBranchForCurrentlyLoggedUser(int $organizationId, int $branchId, array $carData): void
    {
        $organization = $this->organizationRepository->findOneBy(['id' => $organizationId]);
        if ($organization) {
            $loggedUserIdentifier = $this->security->getUser()->getUserIdentifier();
            $organizationAdminIdentifier = $organization->getAdmin()->getUserIdentifier();
            if ($loggedUserIdentifier == $organizationAdminIdentifier) {
                $branches = $organization->getBranches();
                $branch = null;
                foreach ($branches as $localBranch) {
                    if ($localBranch->getId() == $branchId) {
                        $branch = $localBranch;
                    }
                }
                if ($branch) {

                    $car = new Car();
                    $car->setBranch($branch);
                    $car->setBrand($carData['brand']);
                    $car->setModel($carData['model']);
                    $car->setVin($carData['vin']);
                    $car->setSegment($carData['segment']);
                    $car->setBodyType($carData['bodyType']);
                    $car->setColor($carData['color']);
                    $car->setFuel($carData['fuel']);
                    $car->setNumberOfSeats($carData['numberOfSeats']);
                    $car->setNumberOfDoors($carData['numberOfDoors']);
                    $car->setRegistrationNumber($carData['registrationNumber']);
                    $car->setTechnicalExaminationDate(\DateTime::createFromFormat("Y-m-d", $carData['technicalExaminationDate']));
                    $car->setInsuranceExpirationDate(\DateTime::createFromFormat("Y-m-d", $carData['insuranceExpirationDate']));
                    $car->setMileage($carData['mileage']);

                    try {
                        $this->carRepository->save($car, true);
                    } catch (HttpException $exception) {
                        throw new HttpException(500, 'Podczas zapisu pojazdu wystąpił błąd');
                    }

                } else {
                    throw new HttpException(403, 'Brak uprawnień do pobrania zasobu');
                }
            } else {
                throw new HttpException(403, 'Brak uprawnień do zasobu');
            }
        } else {
            throw new HttpException(404, 'Wyszukiwana organizacja nie istnieje');
        }
    }

    public function getCarsFromBranchForCurrentlyLoggedUser(int $organizationId, int $branchId): array
    {
        $organization = $this->organizationRepository->findOneBy(['id' => $organizationId]);
        if ($organization) {
            $loggedUserIdentifier = $this->security->getUser()->getUserIdentifier();
            $organizationAdminIdentifier = $organization->getAdmin()->getUserIdentifier();
            if ($loggedUserIdentifier == $organizationAdminIdentifier) {
                $branches = $organization->getBranches();
                $branch = null;
                foreach ($branches as $localBranch) {
                    if ($localBranch->getId() == $branchId) {
                        $branch = $localBranch;
                    }
                }
                if ($branch) {
                    $response = [];
                    foreach ($branch->getCars() as $car) {
                        array_push(
                            $response,
                            [
                                'id' => $car->getId(),
                                'brand' => $car->getBrand(),
                                'model' => $car->getModel(),
                                'mileage' => $car->getMileage(),
                                'technicalExaminationDate' => $car->getTechnicalExaminationDate()->format('d/m/Y')
                            ]
                        );
                    }
                    return $response;
                } else {
                    throw new HttpException(403, 'Brak uprawnień do pobrania zasobu');
                }
            } else {
                throw new HttpException(403, 'Brak uprawnień do zasobu');
            }
        } else {
            throw new HttpException(404, 'Wyszukiwana organizacja nie istnieje');
        }
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