<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class BookGetCollectionController
 * @package App\Controller
 */
class BookGetCollectionController
{
    /**
     * @param UserInterface $user
     * @param EntityManagerInterface $em
     * @return array
     */
    public function __invoke(UserInterface $user, EntityManagerInterface $em): array
    {
        if ($user instanceof User) {
            return $em->getRepository(Book::class)->findBy(['team' => $user->getTeam()]);
        }

        return [];
    }
}
