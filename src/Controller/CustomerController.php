<?php
declare(strict_types=1);

namespace App\Controller;

use App\Service\CustomerCruder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Routing\Annotation\Route;

/**
 * controller for customer api requests
 *
 * @package   App\Controller
 * @version   0.0.1
 * @since     0.0.1
 *
 * @Route("/foo/kunden", name="api_customer")
 */
class CustomerController extends DefaultController
{
    /**
     * Constructor
     *
     * @param CustomerCruder $customerCruder
     */
    public function __construct(protected CustomerCruder $customerCruder)
    {
    }

    /**
     * List Customers
     * @Route("/", methods={"GET"}, name="list_customer")
     *
     * @param Serializer $serializer
     *
     * @return Response
     */
    public function listCustomerCollection(Serializer $serializer): Response
    {
        try {
            $customerCollection = $this->customerCruder->getActiveCustomerCollection();
            if (empty($customerCollection)) {
                return $this->json([]);
            }

            return $this->json($serializer->normalize($customerCollection));
        } catch (\Throwable $ex) {
            return $this->getJsonFailedResponse($ex);
        }
    }

    /**
     * GET Customer
     * @Route("/{id}", methods={"GET"}, name="get_customer")
     *
     * @param int        $id
     * @param Serializer $serializer
     *
     * @return Response
     */
    public function getCustomer(int $id, Serializer $serializer): Response
    {
        try {
            $return = [];
            $customer = $this->customerCruder->getActiveCustomerById($id);
            if ($customer) {
                $return = $serializer->normalize($customer);
            }

            return $this->json($return);
        } catch (\Throwable $ex) {
            return $this->getJsonFailedResponse($ex);
        }
    }

    /**
     * Create Customer
     * @Route("/", methods={"POST"}, name="create_customer")
     *
     * @param Request    $request
     * @param Serializer $serializer
     *
     * @return Response
     */
    public function createCustomer(Request $request, Serializer $serializer): Response
    {
        try {
            $this->getJsonRequestDecoder()
                 ->decode($request);
            $birthDate = \DateTime::createFromFormat('Y-m-d', (string)$request->get('geburtsdatum'));

            $customer = $this->customerCruder->createCustomer(
                (string)$request->get('name'),
                (string)$request->get('vorname'),
                $birthDate,
                (string)$request->get('geschlecht'),
                (string)$request->get('email'),
                (int)$request->get('vermittlerId'),
                false,
                [],
                null
            );

            return $this->json($serializer->normalize($customer));
        } catch (\Throwable $ex) {
            return $this->getJsonFailedResponse($ex);
        }
    }
}