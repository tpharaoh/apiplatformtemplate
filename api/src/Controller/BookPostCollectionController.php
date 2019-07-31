<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\User;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class BookPostCollectionController
 * @package App\Controller
 */
class BookPostCollectionController
{
    /**
     * @param Book $data
     * @param UserInterface $user
     * @return Book
     */
    public function __invoke(Book $data, UserInterface $user): Book
    {
        if ($user instanceof User) {
            $data->setOwner($user);
            $data->setTeam($user->getTeam());
        }
        $data->setDownloadCount(0);

        return $data;
    }
}
