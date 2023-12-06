<?php

namespace App\Tests\Command;

use App\Command\ImportXmlCommand;
use App\Command\Interfaces\XmlImporterInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use Psr\Log\LoggerInterface;

class ImportXmlCommandTest extends TestCase
{

    private $xmlFile;

    private $flagFile;


    protected function setUp(): void
    {
        $this->xmlFile = sys_get_temp_dir() . '/xml';
        $this->flagFile = sys_get_temp_dir() . '/flag';

        file_put_contents($this->xmlFile, '<xml>test content</xml>');
    }


    protected function tearDown(): void
    {
        unlink($this->xmlFile);
        unlink($this->flagFile);
    }


    public function testExecuteDataImportedSuccessfully()
    {
        $xmlImporterMock = $this->createMock(XmlImporterInterface::class);
        $xmlImporterMock->expects($this->once())
            ->method('import')
            ->with('<xml>test content</xml>');

        $loggerMock = $this->createMock(LoggerInterface::class);
        $command = new ImportXmlCommand($xmlImporterMock, $loggerMock);

        $application = new Application();
        $application->add($command);

        $command = $application->find('import:xml');

        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'command' => $command->getName(),
            '--path' => $this->xmlFile,
            '--flagFile' => $this->flagFile,
        ]);

        $this->assertStringContainsString('Data imported successfully.', $commandTester->getDisplay());
    }


    public function testExecuteFileAlreadyImported()
    {
        $xmlImporterMock = $this->createMock(XmlImporterInterface::class);
        $xmlImporterMock->expects($this->never())
            ->method('import');

        $loggerMock = $this->createMock(LoggerInterface::class);

        $command = new ImportXmlCommand($xmlImporterMock, $loggerMock);

        $application = new Application();
        $application->add($command);

        $command = $application->find('import:xml');
        $commandTester = new CommandTester($command);

        file_put_contents($this->flagFile, 'Import completed on ' . date('Y-m-d H:i:s'));

        $commandTester->execute([
            'command' => $command->getName(),
            '--path' => $this->xmlFile,
            '--flagFile' => $this->flagFile,
        ]);

        $this->assertStringContainsString('File already imported.', $commandTester->getDisplay());
        $this->assertFileExists($this->flagFile);
    }

}