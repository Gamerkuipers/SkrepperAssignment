<?php

namespace App\Service;

use App\Entity\Address;
use App\Repository\AddressRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

class AddressService
{
    public function __construct(private AddressRepository $addressRepository)
    {
    }

    public function getAll(): array
    {
        return $this->addressRepository->findAll();
    }

    public function get(int $id): Address
    {
        return $this->addressRepository->find($id);
    }

    public function create(Address $address): ?Address
    {
        try {
            $this->addressRepository->add($address, true);
        } catch (OptimisticLockException | ORMException $e) {
            return null;
        }
        return $address;
    }
}