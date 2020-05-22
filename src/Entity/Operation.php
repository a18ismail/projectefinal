<?php

namespace App\Entity;

use App\Repository\OperationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OperationRepository::class)
 */
class Operation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $code;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateStart;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateEnd;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $hourlyPay;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity=Port::class, inversedBy="operations")
     */
    private $port;

    /**
     * @ORM\OneToMany(targetEntity=EmployeeHasOperation::class, mappedBy="operation")
     */
    private $operationHasEmployee;

    public function __construct()
    {
        $this->employees = new ArrayCollection();
        $this->operationHasEmployee = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getDateStart(): ?\DateTimeInterface
    {
        return $this->dateStart;
    }

    public function setDateStart(?\DateTime $dateStart): self
    {
        $this->dateStart = $dateStart;

        return $this;
    }

    public function getDateEnd(): ?\DateTimeInterface
    {
        return $this->dateEnd;
    }

    public function setDateEnd(?\DateTime $dateEnd): self
    {
        $this->dateEnd = $dateEnd;

        return $this;
    }

    public function getHourlyPay(): ?float
    {
        return $this->hourlyPay;
    }

    public function setHourlyPay(?float $hourlyPay): self
    {
        $this->hourlyPay = $hourlyPay;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getPort(): ?Port
    {
        return $this->port;
    }

    public function setPort(?Port $port): self
    {
        $this->port = $port;

        return $this;
    }

    /**
     * @return Collection|EmployeeHasOperation[]
     */
    public function getOperationHasEmployee(): Collection
    {
        return $this->operationHasEmployee;
    }

    public function addOperationHasEmployee(EmployeeHasOperation $operationHasEmployee): self
    {
        if (!$this->operationHasEmployee->contains($operationHasEmployee)) {
            $this->operationHasEmployee[] = $operationHasEmployee;
            $operationHasEmployee->setOperation($this);
        }

        return $this;
    }

    public function removeOperationHasEmployee(EmployeeHasOperation $operationHasEmployee): self
    {
        if ($this->operationHasEmployee->contains($operationHasEmployee)) {
            $this->operationHasEmployee->removeElement($operationHasEmployee);
            // set the owning side to null (unless already changed)
            if ($operationHasEmployee->getOperation() === $this) {
                $operationHasEmployee->setOperation(null);
            }
        }

        return $this;
    }
}
