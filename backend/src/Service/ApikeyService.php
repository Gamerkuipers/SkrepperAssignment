<?php

namespace App\Service;

use App\Entity\ApiKey;
use App\Repository\ApiKeyRepository;

class ApikeyService
{
    public function __construct(private ApiKeyRepository $apiKeyRepository)
    {
    }

    public function findoneByKey(string $key): ?ApiKey
    {
        return $this->apiKeyRepository->findOneByKey($key);
    }
}