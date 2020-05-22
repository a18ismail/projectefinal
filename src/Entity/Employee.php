<?php

namespace App\Entity;

use App\Repository\EmployeeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EmployeeRepository::class)
 */
class Employee
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=250, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=250, nullable=true)
     */
    private $surnames;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nif;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $phoneNumber;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $birthday;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nss;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $notes;

    /**
     * @ORM\Column(name="snsTwitter", type="string", length=255, nullable=true)
     */
    private $snsTwitter;

    /**
     * @ORM\Column(name="snsLinkedin", type="string", length=255, nullable=true)
     */
    private $snsLinkedin;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $postcode;

    /**
     * @ORM\OneToMany(targetEntity=EmployeeHasOperation::class, mappedBy="employee")
     */
    private $employeeHasOperations;

    public function __construct()
    {
        $this->employeeHasOperations = new ArrayCollection();
    }


    //birthday, address, postcode, nss, notes, sns_twitter, sns_linkedin
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSurnames(): ?string
    {
        return $this->surnames;
    }

    public function setSurnames(?string $surnames): self
    {
        $this->surnames = $surnames;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getNif(): ?string
    {
        return $this->nif;
    }

    public function setNif(string $nif): self
    {
        $this->nif = $nif;

        return $this;
    }

    public function getPhoneNumber(): ?int
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?int $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(?\DateTime $birthday): self
    {
        $this->birthday = $birthday;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getNss(): ?string
    {
        return $this->nss;
    }

    public function setNss(?string $nss): self
    {
        $this->nss = $nss;

        return $this;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function setNotes(?string $notes): self
    {
        $this->notes = $notes;

        return $this;
    }

    public function getSnsTwitter(): ?string
    {
        return $this->snsTwitter;
    }

    public function setSnsTwitter(?string $snsTwitter): self
    {
        $this->snsTwitter = $snsTwitter;

        return $this;
    }

    public function getSnsLinkedin(): ?string
    {
        return $this->snsLinkedin;
    }

    public function setSnsLinkedin(?string $snsLinkedin): self
    {
        $this->snsLinkedin = $snsLinkedin;

        return $this;
    }

    public function getPostcode(): ?int
    {
        return $this->postcode;
    }

    public function setPostcode(?int $postcode): self
    {
        $this->postcode = $postcode;

        return $this;
    }

    /**
     * @return Collection|EmployeeHasOperation[]
     */
    public function getEmployeeHasOperations(): Collection
    {
        return $this->employeeHasOperations;
    }

    public function addEmployeeHasOperation(EmployeeHasOperation $employeeHasOperation): self
    {
        if (!$this->employeeHasOperations->contains($employeeHasOperation)) {
            $this->employeeHasOperations[] = $employeeHasOperation;
            $employeeHasOperation->setEmployee($this);
        }

        return $this;
    }

    public function removeEmployeeHasOperation(EmployeeHasOperation $employeeHasOperation): self
    {
        if ($this->employeeHasOperations->contains($employeeHasOperation)) {
            $this->employeeHasOperations->removeElement($employeeHasOperation);
            // set the owning side to null (unless already changed)
            if ($employeeHasOperation->getEmployee() === $this) {
                $employeeHasOperation->setEmployee(null);
            }
        }

        return $this;
    }

}
