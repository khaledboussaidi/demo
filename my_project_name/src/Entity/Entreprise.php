<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EntrepriseRepository")
 */
class Entreprise implements UserInterface,\serializable
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
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Stage", mappedBy="entreprise", orphanRemoval=true)
     */
    private $stage;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $location;





    public function __construct()
    {
        $this->stager = new ArrayCollection();
        $this->stage = new ArrayCollection();

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }
    public function getRoles(){
        return [
            'ROLE_ADMIN'
        ];


    }
    public function getSalt(){}
    public function eraseCredentials(){}
    public function serialize()
    {
        return serialize([
            $this->id,
            $this->username,
            $this->email,
            $this->password

        ]);
    }
    public function unserialize($string)
    {
        list(
            $this->id,
            $this->username,
            $this->email,
            $this->password
            )=unserialize($string,['allowed_classes'=>false]);
    }

    /**
     * @return Collection|Stager[]
     */
    public function getStager(): Collection
    {
        return $this->stager;
    }

    public function addStager(Stager $stager): self
    {
        if (!$this->stager->contains($stager)) {
            $this->stager[] = $stager;
            $stager->setEntreprise($this);
        }

        return $this;
    }

    public function removeStager(Stager $stager): self
    {
        if ($this->stager->contains($stager)) {
            $this->stager->removeElement($stager);
            // set the owning side to null (unless already changed)
            if ($stager->getEntreprise() === $this) {
                $stager->setEntreprise(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Stage[]
     */
    public function getStage(): Collection
    {
        return $this->stage;
    }

    public function addStage(Stage $stage): self
    {
        if (!$this->stage->contains($stage)) {
            $this->stage[] = $stage;
            $stage->setEntreprise($this);
        }

        return $this;
    }

    public function removeStage(Stage $stage): self
    {
        if ($this->stage->contains($stage)) {
            $this->stage->removeElement($stage);
            // set the owning side to null (unless already changed)
            if ($stage->getEntreprise() === $this) {
                $stage->setEntreprise(null);
            }
        }

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): self
    {
        $this->location = $location;

        return $this;
    }


}
