<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Table(name="favourites")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FavouriteRepository")
 */
class Favourite
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    public $id;

    /**
     * @ORM\Column(type="integer")
     */
    public $userId;

    /**
     * @ORM\Column(type="integer")
     */
    public $characterId;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set userId
     *
     * @param integer $userId
     *
     * @return Favourite
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set characterId
     *
     * @param integer $characterId
     *
     * @return Favourite
     */
    public function setCharacterId($characterId)
    {
        $this->characterId = $characterId;

        return $this;
    }

    /**
     * Get characterId
     *
     * @return int
     */
    public function getCharacterId()
    {
        return $this->characterId;
    }
}

