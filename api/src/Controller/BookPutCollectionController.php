<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\User;
use Symfony\Component\Security\Core\User\UserInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class BookPutCollectionController
 * @package App\Controller
 */
class BookPutCollectionController
{
    /**
     * @param Book $data
     * @param UserInterface $user
     * @return Book
     */
    public function __invoke(Book $data, UserInterface $user, LoggerInterface $logger, Request $request): Book
    {
        // if ($user instanceof User) {
        //     $data->setOwner($user);
        //     $data->setTeam($user->getTeam());
            
        // }
        
        $postData = json_decode($request->getContent(), true);
        $logger->info(count($postData));
        if(count($postData)==1&&isset($postData['downloadCount'])){
            $logger->info('send messenger !!!!!!');
        }else{
            $logger->info('NO **** messenger');
        }
        // $data->setDownloadCount(3);
        // dump($data);
        return $data;
    }
}
