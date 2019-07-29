<?php

// api/src/Handler/ResetPasswordRequestHandler.php

namespace App\Handler;

use App\Entity\BookUpdateDownloadCount;
use App\Entity\Book;
use App\Repository\BookRepository;

use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Psr\Log\LoggerInterface;
use Doctrine\ORM\EntityManagerInterface;

final class BookUpdateDownloadCountHandler implements MessageHandlerInterface
{
    private $bookRepository;
    private $logger;
    private $entityManager;

    public function __construct(BookRepository $bookRepository, LoggerInterface $logger, EntityManagerInterface $entityManager)
    {
        $this->bookRepository = $bookRepository;
        $this->logger=$logger;
        $this->entityManager = $entityManager;
    }

    public function __invoke(BookUpdateDownloadCount $id)
    {
        
        sleep(10);
        
        $book = $this->bookRepository->find($id->book_id);
        $this->logger->info(serialize($book));
        $book->setDownloadCount($book->getDownloadCount()+1);
        $this->entityManager->flush();
    }
}