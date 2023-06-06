<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\CustomerEntity;
use App\Repository\CustomerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * CRUD operations Manager for Customers Entity
 *
 * @package   App\Service
 * @version   0.0.1
 * @since     0.0.1
 */
class CustomerCruder
{
    /** Constructor
     *
     * @param EntityManagerInterface  $entityManager
     * @param ValidatorInterface|null $validator
     * @param CustomerRepository|null $customerRepository
     */
    public function __construct(
        protected EntityManagerInterface $entityManager,
        protected ?ValidatorInterface $validator = null,
        protected CustomerRepository|EntityRepository|null $customerRepository = null
    ) {
        $this->customerRepository = $this->entityManager->getRepository(CustomerEntity::class);
    }

    /**
     * load customers
     *
     * @return CustomerEntity[]
     */
    public function getActiveCustomerCollection(): array
    {
        return $this->customerRepository->findActiveCustomersCollection();
    }

    /**
     * getCustomerById
     *
     * @param int $id
     *
     * @return CustomerEntity
     */
    public function getCustomerById(int $id): CustomerEntity
    {
        return $this->entityManager->getRepository(CustomerEntity::class)
                                   ->find([$id]);
    }

    /**
     * getActiveCustomerById
     *
     * @param int $id
     *
     * @return CustomerEntity
     * @throws NonUniqueResultException
     */
    public function getActiveCustomerById(int $id): CustomerEntity
    {
        return $this->customerRepository->getActiveCustomerById($id);
    }

    /**
     * Create Customer
     *
     * @param string         $lastName
     * @param string         $firstName
     * @param \DateTime|null $birthDateTime
     * @param string         $gender
     * @param string         $email
     * @param int            $agentId
     * @param bool           $isDeleted
     * @param array          $addressesIds
     *
     * @return CustomerEntity
     */
    public function createCustomer(
        string $lastName = '',
        string $firstName = '',
        ?\DateTime $birthDateTime = null,
        string $gender = '',
        string $email = '',
        int $agentId = 0,
        bool $isDeleted = false,
        array $addressesIds = [],
    ): CustomerEntity {
        $customer = new CustomerEntity();
        $customer->setLastName(trim($lastName))
                 ->setFirstName(trim($firstName))
                 ->setBirthDateTime($birthDateTime)
                 ->setIsDeleted($isDeleted)
                 ->setGender(trim($gender))
                 ->setEmail(trim($email))
                 ->setAgentId($agentId);

        // @todo set Agent and Addresses data

        // @todo validation

        $this->entityManager->persist($customer);
        $this->entityManager->flush();

        return $customer;
    }
}