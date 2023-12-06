<?php

namespace App\Command;

use App\Command\Interfaces\XmlImporterInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Style\SymfonyStyle;
use Psr\Log\LoggerInterface;

class ImportXmlCommand extends Command
{

    private $xmlImporter;

    private $logger;

    private $flagFile;


    public function __construct(XmlImporterInterface $xmlImporter, LoggerInterface $logger)
    {
        parent::__construct();

        $this->xmlImporter = $xmlImporter;
        $this->logger = $logger;
    }


    protected function configure(): void
    {
        $this
            ->setName('import:xml')
            ->setDescription('Import XML data')
            ->addOption('path', null, InputOption::VALUE_OPTIONAL, 'Path to XML file', 'data/feed.xml')
            ->addOption('flagFile', null, InputOption::VALUE_OPTIONAL, 'Path to the flag file', 'var/log/import_flag.txt');
    }


    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $consoleInteraction = new SymfonyStyle($input, $output);

        $this->logger->info('ImportXmlCommand started.');

        $path = $input->getOption('path');
        $this->flagFile = $input->getOption('flagFile');

        if ($this->isAlreadyImported()) {
            $consoleInteraction->success('File already imported.');
            return 0;
        }

        try {
            $xmlContent = file_get_contents($path);
            if ($xmlContent === false) {
                throw new \Exception('Failed to read XML file.');
            }

            $this->xmlImporter->import($xmlContent);
            $this->setImportFlag();

            $consoleInteraction->success('Data imported successfully.');
            return 0;

        } catch (\Exception $e) {
            $this->logger->error('Error in the import process: ' . $e->getMessage());
            $consoleInteraction->error('Error: ' . $e->getMessage());

            $this->logger->error($e->getMessage(), ['exception' => $e]);
            return 1;
        }
    }


    public function isAlreadyImported(): bool
    {
        return file_exists($this->flagFile);
    }


    /**
     * @throws \Exception
     */
    private function setImportFlag(): void
    {
        $logMessage = 'Import completed on ' . date('Y-m-d H:i:s');
        file_put_contents($this->flagFile, $logMessage);
    }

}