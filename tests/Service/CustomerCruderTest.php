<?php

namespace App\Tests\Service;

use App\Entity\CustomerEntity;
use App\Repository\CustomerRepository;
use App\Service\CustomerCruder;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * CustomerCruderTest
 * @package App\Tests\Service
 */
final class CustomerCruderTest extends TestCase
{
    protected EntityManagerInterface $entityManager;

    protected ValidatorInterface $validator;

    protected CustomerRepository $customerRepository;

    protected CustomerCruder $customerCruder;

    protected function setUp(): void
    {
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $this->customerRepository = $this->createMock(CustomerRepository::class);
        $this->validator = $this->createMock(ValidatorInterface::class);
        $this->customerCruder = new CustomerCruder($this->entityManager, $this->validator, $this->customerRepository);
    }

    /**
     * testGetActiveCustomerCollection
     * @covers \App\Service\CustomerCruder::__construct
     * @covers \App\Service\CustomerCruder::getActiveCustomerCollection
     * @return void
     */
    public function testGetActiveCustomerCollection(): void
    {
        $customerEntity1 = new CustomerEntity();
        $customerEntity2 = new CustomerEntity();
        $this->customerRepository->expects($this->once())
                                 ->method('findActiveCustomersCollection')
                                 ->willReturn([$customerEntity1, $customerEntity2]);

        $result = $this->customerCruder->getActiveCustomerCollection();

        // Assertions
        $this->assertIsArray($result);
        $this->assertCount(2, $result);
        $this->assertInstanceOf(CustomerEntity::class, $result[0]);
        $this->assertInstanceOf(CustomerEntity::class, $result[1]);
    }

    /**
     * testGetCustomerById
     * @covers \App\Service\CustomerCruder::__construct
     * @covers \App\Service\CustomerCruder::getCustomerById
     * @return void
     */
    public function testGetCustomerById(): void
    {
        $customerId = 1;
        $lastName = 'Zimmermann';
        $customerEntity = new CustomerEntity();
        $customerEntity->setLastName($lastName);
        // Configure the entity manager mock
        $this->entityManager->expects($this->once())
                            ->method('getRepository')
                            ->with(CustomerEntity::class)
                            ->willReturn($this->customerRepository);
        $this->customerRepository->expects($this->once())
                                 ->method('find')
                                 ->with([$customerId])
                                 ->willReturn($customerEntity);

        $result = $this->customerCruder->getCustomerById($customerId);

        $this->assertInstanceOf(CustomerEntity::class, $result);
        $this->assertEquals($customerId, $result->getId());
        $this->assertEquals($lastName, $result->getLastName());
    }

    /**
     * testGetActiveCustomerById
     * @covers \App\Service\CustomerCruder::__construct
     * @covers \App\Service\CustomerCruder::getActiveCustomerById
     * @return void
     * @throws NonUniqueResultException
     */
    public function testGetActiveCustomerById()
    {
        $customerId = 1;
        $customerEntity = new CustomerEntity();
        $this->customerRepository->expects($this->once())
                                 ->method('getActiveCustomerById')
                                 ->with($customerId)
                                 ->willReturn($customerEntity);

        $result = $this->customerCruder->getActiveCustomerById($customerId);

        $this->assertInstanceOf(CustomerEntity::class, $result);
        $this->assertEquals($customerId, $result->getId());
    }

    /**
     * @dataProvider customerDataProvider
     */
    public function testCreateCustomer(string $expected = '', array $incoming = [])
    {
        $lastName = $incoming['lastName'];

        $this->entityManager->expects($this->once())
                            ->method('persist')
                            ->willReturnCallback(function ($customer) use ($lastName) {
                                $this->assertInstanceOf(CustomerEntity::class, $customer);
                                $this->assertEquals($lastName, $customer->getLastName());
                            });
        $this->entityManager->expects($this->once())
                            ->method('flush');

        $result = $this->customerCruder->createCustomer(
            $lastName,
            $incoming['firstName'],
            $incoming['birthDateTime'],
            $incoming['gender'],
            $incoming['email'],
            $incoming['agentId'],
            $incoming['isDeleted'],
            $incoming['addressesIds'],
        );

        $this->assertInstanceOf(CustomerEntity::class, $result);
        $this->assertEquals($expected, $result->getFirstName());
    }

    /**
     * Test Cases Data Provider
     * @return \Generator
     */
    public function customerDataProvider(): \Generator
    {
        yield 'task data' => [
            'expected' => 'Max',
            'incoming' => [
                'lastName'      => 'Mustermann',
                'firstName'     => 'Max',
                'birthDateTime' => new \DateTime('1970-01-01'),
                'gender'        => 'male',
                'email'         => 'max.mustermann@example.org',
                'agentId'       => 1000,
                'isDeleted'     => false,
                'addressesIds'  => []
            ],
        ];

        yield 'correct data' => [
            'expected' => 'John',
            'incoming' => [
                'lastName'      => 'Doe',
                'firstName'     => 'John',
                'birthDateTime' => new \DateTime('1990-01-01'),
                'gender'        => 'male',
                'email'         => 'john.doe@example.com',
                'agentId'       => 123,
                'isDeleted'     => false,
                'addressesIds'  => [1, 2, 3]
            ],
        ];
    }
}
