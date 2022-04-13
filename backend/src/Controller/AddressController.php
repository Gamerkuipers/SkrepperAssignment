<?php

namespace App\Controller;

use App\Entity\Address;
use App\Service\AddressService;
use App\Service\ApikeyService;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/address', name: 'address_', requirements: ['username' => '\w+', 'apikey' => '\w+'], methods: 'POST')]
class AddressController extends AbstractController
{
    #[Route('', name: 'index')]
    public function index(Request $request,AddressService $addressService, UserService $userService, ApikeyService $apikeyService): Response
    {
        if (!$this->isValidCall($request, $userService, $apikeyService)) return $this->json('');
        return $this->json($addressService->getAll());
    }

    #[Route('/{id}', name: 'get', requirements: ['id' => '\d+'])]
    public function get(Request $request, AddressService $addressService, UserService $userService,ApikeyService $apikeyService, int $id): Response
    {
        if (!$this->isValidCall($request, $userService, $apikeyService)) return $this->json('');
        return $this->json($addressService->get($id));
    }

    #[Route('/create', name: 'create')]
    public function create(Request $request, AddressService $addressService, UserService $userService,ApikeyService $apikeyService): Response
    {
        if (!$this->isValidCall($request, $userService, $apikeyService)) return $this->json('');
        $data = $request->request;

        if (!$data->get('name')) return new Response('Name Can\'t be empty.');

        $address = new Address();
        $address->setName($data->get('name'));
        $address->setPhoneNumber($data->get('phoneNumber', null));
        $address->setDescription($data->get('description', null));

        return $this->json($addressService->create($address));
    }

    public function isValidCall(Request $request, UserService $userService, ApikeyService $apikeyService): bool
    {
        $data = $request->request;
        $user = $userService->findbyName($data->get('username'));

        $apikey = $apikeyService->findOneByKey($data->get('apikey'));

        if ($user !== null) {
            return $user->getApiKeys()->contains($apikey);
        }
        return false;
    }
}
