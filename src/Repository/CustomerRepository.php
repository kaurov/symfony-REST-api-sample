<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\CustomerEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Doctrine Repository class for CustomerEntity
 * @package   App\Repository
 * @version   0.0.1
 * @since     0.0.1
 *
 * @method CustomerEntity find($id, $lockMode = null, $lockVersion = null)
 * @method CustomerEntity findOneBy(array $criteria, array $orderBy = null)
 * @method CustomerEntity[] findAll()
 * @method CustomerEntity[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CustomerRepository extends ServiceEntityRepository
{
    /**
     * class constructor
     *
     * @param \Doctrine\Persistence\ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CustomerEntity::class);
    }

    /**
     * find all customers, which are not deleted
     *
     * @return CustomerEntity[]
     */
    public function findActiveCustomersCollection(): array
    {
        $queryBuilder = $this->createQueryBuilder('customer')
                             ->where('customer.isDeleted = :isDeleted')
                             ->setParameter(':isDeleted', false)
                             ->orderBy('customer.id', 'ASC');

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * Search customer by identifier, active one only
     *
     * @param int $id
     *
     * @return CustomerEntity|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getActiveCustomerById(int $id): ?CustomerEntity
    {
        $queryBuilder = $this->createQueryBuilder('customer')
                             ->where('customer.id = :customerId')
                             ->andWhere('customer.isDeleted = :isDeleted')
                             ->setParameter(':customerId', $id)
                             ->setParameter(':isDeleted', false)
                             ->setMaxResults(1);

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }
}