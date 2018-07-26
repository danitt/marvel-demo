<?php

namespace AppBundle\Repository;

use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Doctrine\ORM\EntityRepository;

use AppBundle\Entity\Favourite;

class FavouriteRepository extends \Doctrine\ORM\EntityRepository
{

  /**
   * Gets user favourites, optionally refined by characterId
   */
  public function getFavourites($userId, $characterId = null)
  {
    $qb = $this->createQueryBuilder('f')
      ->where('f.userId = :userId')
      ->setParameter('userId', $userId);
    if (!is_null($characterId)) {
      $qb->andWhere('f.characterId = :characterId')
        ->setParameter('characterId', $characterId);
    }
    return $qb->getQuery();
  }

  /**
   * Creates or updates a favourite record for specified user and character
   */
  public function addFavourite($userId, $characterId)
  {
    // Find if already favourited
    $existingFavourite = $this->createQueryBuilder('f')
      ->where('f.userId = :userId')
      ->andWhere('f.characterId = :characterId')
      ->setParameter('userId', $userId)
      ->setParameter('characterId', $characterId)
      ->getQuery()
      ->getOneOrNullResult();

    if (is_null($existingFavourite)) {
      $favourite = new Favourite();
      $favourite->userId = $userId;
      $favourite->characterId = $characterId;
      $entityManager = $this->getEntityManager();
      $entityManager->persist($favourite);
      $entityManager->flush();
    }

    return true;
  }

  /**
   * Removes favourite if exists
   */
  public function removeFavourite($userId, $characterId)
  {
    // Find if already favourited
    $favourite = $this->createQueryBuilder('f')
      ->where('f.userId = :userId')
      ->andWhere('f.characterId = :characterId')
      ->setParameter('userId', $userId)
      ->setParameter('characterId', $characterId)
      ->getQuery()
      ->getOneOrNullResult();

    if (!is_null($favourite)) {
      $entityManager = $this->getEntityManager();
      $entityManager->remove($favourite);
      $entityManager->flush();
    }

    return true;
  }

}
