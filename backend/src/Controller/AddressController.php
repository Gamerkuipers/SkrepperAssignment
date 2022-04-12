<?php

namespace App\Controller;

use App\Entity\Address;
use App\Service\AddressService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/address', name: 'address_')]
class AddressController extends AbstractController
{
    #[Route('/', name: 'index', methods: 'GET')]
    public function index(AddressService $addressService): Response
    {
        return $this->json($addressService->getAll());
    }

    #[Route('/{id}', name: 'get', requirements: ['id' => '\d+'], methods: 'GET')]
    public function get(AddressService $addressService, int $id): Response
    {
        return $this->json($addressService->get($id));
    }

    #[Route('/create', name: 'create', methods: 'POST')]
    public function create(Request $request, AddressService $addressService): Response
    {
        $data = $request->request;

        if (!$data->get('name')) return new Response('Name Can\'t be empty.');

        $address = new Address();
        $address->setName($data->get('name'));
        $address->setPhoneNumber($data->get('phoneNumber', null));
        $address->setDescription($data->get('description', null));

        return $this->json($addressService->create($address));
    }
}
