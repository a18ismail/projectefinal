<?php

namespace App\Entity;

use App\Repository\EmployeeHasOperationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EmployeeHasOperationRepository::class)
 */
class EmployeeHasOperation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Employee::class, inversedBy="employeeHasOperations")
     */
    private $employee;

    /**
     * @ORM\ManyToOne(targetEntity=Operation::class, inversedBy="operationHasEmployee")
     */
    private $operation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $status;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $realDuration;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $timeLeft;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmployee(): ?Employee
    {
        return $this->employee;
    }

    public function setEmployee(?Employee $employee): self
    {
        $this->employee = $employee;

        return $this;
    }

    public function getOperation(): ?Operation
    {
        return $this->operation;
    }

    public function setOperation(?Operation $operation): self
    {
        $this->operation = $operation;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getRealDuration(): ?float
    {
        return $this->realDuration;
    }

    public function setRealDuration(?float $realDuration): self
    {
        $this->realDuration = $realDuration;

        return $this;
    }

    public function getTimeLeft(): ?\DateTimeInterface
    {
        return $this->timeLeft;
    }

    public function setTimeLeft(?\DateTimeInterface $timeLeft): self
    {
        $this->timeLeft = $timeLeft;

        return $this;
    }
}
