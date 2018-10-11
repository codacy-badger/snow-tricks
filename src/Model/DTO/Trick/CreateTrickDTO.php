<?php

namespace App\Model\DTO\Trick;

use App\Model\Entity\TrickGroup;
use Symfony\Component\Validator\Constraints as Assert;

class CreateTrickDTO
{
    /**
     * @var string
     *
     * @Assert\Length(min=3);
     */
    private $name;

    /**
     * @var string
     *
     * @Assert\Length(min=20)
     */
    private $description;

    /**
     * @var TrickGroup
     */
    private $trickGroup;

    /**
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return TrickGroup
     */
    public function getTrickGroup(): ?TrickGroup
    {
        return $this->trickGroup;
    }

    /**
     * @param TrickGroup $trickGroup
     */
    public function setTrickGroup(?TrickGroup $trickGroup): void
    {
        $this->trickGroup = $trickGroup;
    }


}
