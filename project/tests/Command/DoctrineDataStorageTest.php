<?php

namespace App\Tests\Command;

use App\Command\Services\DoctrineDataStorage;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class DoctrineDataStorageTest extends TestCase
{

    public function testSave()
    {
        $entityManagerMock = $this->createMock(EntityManagerInterface::class);
        $loggerMock = $this->createMock(LoggerInterface::class);

        $doctrineDataStorage = new DoctrineDataStorage($entityManagerMock, $loggerMock);

        $productMock = $this->createMock(Product::class);

        $entityManagerMock
            ->expects($this->once())
            ->method('persist');

        $entityManagerMock
            ->expects($this->once())
            ->method('flush');

        $doctrineDataStorage->save($productMock);
    }

}