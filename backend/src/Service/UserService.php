<?php

namespace App\Service;

use App\Entity\ApiKey;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class UserService
{
    public function __construct(private UserRepository $userRepository, private Security $security)
    {
    }

    public function getUser(): UserInterface
    {
        return $this->security->getUser();
    }

    public function createApiKey(ManagerRegistry $doctrine)
    {
        $user = $this->getUser();

        $apiKey = new ApiKey();
        // this is temporary key generator
        $key = $user->getUsername() . count($user->getApiKeys());
        $apiKey->setKey($key);
        $apiKey->setEnabled(true);

        $user->addApiKey($apiKey);

        $manager = $doctrine->getManager();
        $manager->persist($user);
        $manager->persist($apiKey);
        $manager->flush();
    }

    /**
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\ORMException
     */
    public function createUser(User $user, bool $flush = true): ?User
    {
        try {
        $this->userRepository->add($user, $flush);
        } catch (OptimisticLockException | ORMException $e) {
            return null;
        }
        return $user;
    }

    public function findbyName(string $name): ?UserInterface
    {
        return $this->userRepository->findOneByUsername($name);
    }
}