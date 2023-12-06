<?php

namespace App\Tests\Command;

use App\Command\Interfaces\DataStorageInterface;
use App\Command\Services\XmlImporter;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class XmlImporterTest extends TestCase
{

    public function testImport()
    {
        $dataStorageMock = $this->createMock(DataStorageInterface::class);
        $loggerMock = $this->createMock(LoggerInterface::class);

        $xmlImporter = new XmlImporter($dataStorageMock, $loggerMock);

        $xmlContent = '<items><item><entity_id>1</entity_id><sku>123</sku></item></items>';

        $dataStorageMock
            ->expects($this->once())
            ->method('save');

        $xmlImporter->import($xmlContent);
    }

}