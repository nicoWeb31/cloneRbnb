<?php

namespace App\Entity;

use App\Repository\PassUpdateRepository;
use Symfony\Component\Validator\Constraints as Assert;


class PassUpdate
{



    private $oldPassword;

    /**
     * @Assert\Length(min=8,minMessage="Votre mot de passe doit faire au moins 8 caractéres ! ")
     */
    private $newPass;

    /**
     * @Assert\EqualTo(propertyPath = "newPass", message ="comfirmation incorrect")
     */
    private $ComfirmPass;



    public function getOldPassword(): ?string
    {
        return $this->oldPassword;
    }

    public function setOldPassword(string $oldPassword): self
    {
        $this->oldPassword = $oldPassword;

        return $this;
    }

    public function getNewPass(): ?string
    {
        return $this->newPass;
    }

    public function setNewPass(string $newPass): self
    {
        $this->newPass = $newPass;

        return $this;
    }

    public function getComfirmPass(): ?string
    {
        return $this->ComfirmPass;
    }

    public function setComfirmPass(string $ComfirmPass): self
    {
        $this->ComfirmPass = $ComfirmPass;

        return $this;
    }
}
