<?php
declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Ignore;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Type;

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
     *
     * @param string         $lastName
     * @param string         $firstName
     * @param \DateTime|null $birthDateTime
     * @param string         $gender
     * @param string         $email
     * @param int            $agentId
     * @param bool           $isDeleted
     * @param                $addresses
     * @param                $agent
     */
    public function __construct(
        #[ORM\Column(type: "string", name: "name")]
        #[Assert\NotBlank(message: "Customer name is required.")]
        #[SerializedName('name')]
        protected string $lastName = '',

        #[ORM\Column(type: "string", name: "vorname")]
        #[Assert\NotBlank(message: "customer first name is required.")]
        #[SerializedName('vorname')]
        protected string $firstName = '',

        /**
         * @SerializedName("geburtsdatum")
         * @Type("DateTime<'Y-m-d'>")
         */
        #[ORM\Column(type: "datetime", name: "geburtsdatum", columnDefinition: "timestamp default current_timestamp")]
        #[Assert\DateTime(message: "Birth date should be null or valid date Y-m-d like 1970-01-01")]
        #[SerializedName('geburtsdatum')]
        protected ?\DateTime $birthDateTime = null,

        #[ORM\Column(type: "string", name: "geschlecht", nullable: true)]
        #[Assert\Choice(choices: self::GENDER_ALLOWED, message: "Invalid gender value")]
        #[SerializedName('geschlecht')]
        protected string $gender = '',

        #[ORM\Column(type: "string", name: "email", nullable: true)]
        #[Assert\Email(message: "Invalid email address!")]
        protected string $email = '',

        #[ORM\Column(type: "string", name: "vermittler_id")]
        protected int $agentId = 0,

        #[ORM\Column(type: "boolean", name: "geloescht", nullable: false)]
        #[Ignore]
        protected bool $isDeleted = false,

        // @todo connect to Entities
        protected $addresses = null,
        protected $agent = null,
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
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * setName
     *
     * @param string|null $lastName
     *
     * @return $this
     */
    public function setLastName(?string $lastName): static
    {
        $this->lastName = (string)$lastName;

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
     * setGender
     * @return string|null
     */
    public function getGender(): ?string
    {
        return $this->gender;
    }

    /**
     * setGender
     *
     * @param string|null $gender
     *
     * @return $this
     */
    public function setGender(?string $gender): static
    {
        $this->gender = (string)$gender;

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