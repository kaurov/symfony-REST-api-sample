<?php
declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Customers Entity
 *
 * @ORM\Table(name="tbl_kunden", schema="std")
 * @ORM\Entity(repositoryClass="App\Repository\CustomerRepository")
 * @ApiResource(
 *     collectionOperations={
 *         "get"={"path"="/kunden.{_format}"},
 *         "post"={"path"="/kunden.{_format}"},
 *     },
 *     itemOperations={
 *         "get" = {"path"="/kunden/{id}.{_format}"},
 *         "put" = {"path"="/kunden/{id}.{_format}"},
 *         "delete" = {"path"="/kunden/{id}.{_format}"},
 *     },
 * )
 * @package   App\Entity
 * @version   0.0.1
 * @since     0.0.1
 *
 */
class CustomerEntity extends AbstractEntity
{
    const GENDER_ALLOWED = ['male', 'female', ''];

    /**
     * Constructor
     * @param string         $firstName
     * @param string         $name
     * @param \DateTime|null $birthDateTime
     * @param bool           $isDeleted
     * @param string         $sex
     * @param string         $email
     * @param int            $agentId
     */
    public function __construct(
        #[ORM\Column(type: "string", name: "vorname")]
        #[Assert\NotBlank(message: "customer first name is required.")]
        string $firstName = '',

        #[ORM\Column(type: "string", name: "name")]
        #[Assert\NotBlank(message: "Customer name is required.")]
        string $name = '',

        #[ORM\Column(type: "datetime", name: "geburtsdatum", columnDefinition: "timestamp default current_timestamp")]
        ?\DateTime $birthDateTime = null,

        #[ORM\Column(type: "boolean", name: "geloescht", nullable: false)]
        bool $isDeleted = false,

        #[ORM\Column(type: "string", name: "geschlecht", nullable: true)]
        #[Assert\Choice(choices: static::GENDER_ALLOWED, message: "Invalid gender value")]
        string $sex = '',

        #[ORM\Column(type: "string", name: "email", nullable: true)]
        #[Assert\Email(message: "Invalid email address!")]
        string $email = '',

        #[ORM\Column(type: "string", name: "vermittler_id")]
        int $agentId = 0
    ) {

    }

    /**
     * getFirstName
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * setFirstName
     *
     * @param string|null $firstName
     *
     * @return $this
     */
    public function setFirstName(?string $firstName): static
    {
        $this->firstName = (string)$firstName;

        return $this;
    }

    /**
     * getName
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * setName
     *
     * @param string|null $name
     *
     * @return $this
     */
    public function setName(?string $name): static
    {
        $this->name = (string)$name;

        return $this;
    }

    /**
     * getBirthDateTime
     * @return \DateTime|null
     */
    public function getBirthDateTime(): ?\DateTime
    {
        return $this->birthDateTime;
    }

    /**
     * setBirthDateTime
     *
     * @param \DateTime|null $birthDateTime
     *
     * @return $this
     */
    public function setBirthDateTime(?\DateTime $birthDateTime): static
    {
        $this->birthDateTime = $birthDateTime;

        return $this;
    }

    /**
     * getIsDeleted
     * @return bool
     */
    public function getIsDeleted(): bool
    {
        return $this->isDeleted;
    }

    /**
     * setIsDeleted
     *
     * @param bool $isDeleted
     *
     * @return $this
     */
    public function setIsDeleted(bool $isDeleted): static
    {
        $this->isDeleted = $isDeleted;

        return $this;
    }

    /**
     * getSex
     * @return string|null
     */
    public function getSex(): ?string
    {
        return $this->sex;
    }

    /**
     * setSex
     *
     * @param string|null $sex
     *
     * @return $this
     */
    public function setSex(?string $sex): static
    {
        $this->sex = (string)$sex;

        return $this;
    }

    /**
     * getEmail
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * setEmail
     *
     * @param string|null $email
     *
     * @return $this
     */
    public function setEmail(?string $email): static
    {
        $this->email = (string)$email;

        return $this;
    }

    /**
     * getAgentId
     * @return int
     */
    public function getAgentId(): int
    {
        return $this->agentId;
    }

    /**
     * setAgentId
     *
     * @param int $agentId
     *
     * @return $this
     */
    public function setAgentId(int $agentId): static
    {
        $this->agentId = $agentId;

        return $this;
    }
}