<?php

namespace App\Command\Services;

use App\Command\Interfaces\DataStorageInterface;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

class DoctrineDataStorage implements DataStorageInterface
{

    private $entityManager;

    private $logger;

    public function __construct(EntityManagerInterface $entityManager, LoggerInterface $logger)
    {
        $this->entityManager = $entityManager;
        $this->logger = $logger;
    }


    public function save(Product $product): void
    {
        try {
            $this->entityManager->persist($product);
            $this->entityManager->flush();
        } catch (\Exception $e) {
            $this->logger->error('Error saving product to the database: ' . $e->getMessage());
        }
    }

}