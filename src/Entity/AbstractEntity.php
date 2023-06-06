<?php
declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Default Entity to be inherited by all Entities
 * @package   App\Entity
 */
abstract class AbstractEntity
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", nullable=false)
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Groups({"read"})
     */
    protected string $id;

    /**
     * getId
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * setId
     *
     * @param string $id
     *
     * @return $this
     */
    public function setId(string $id): static
    {
        $this->id = $id;

        return $this;
    }
}