<?php

namespace App\Command;

use App\Service\ProviderService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class InstallCommand extends Command
{
    protected static $defaultName = 'app:install';
    /**
     * @var ProviderService
     */
    private $service;

    public function __construct(ProviderService $service)
    {
        parent::__construct('app:install');
        $this->service = $service;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $io->note("Connecting " . count($this->service->getProviders()) . " API...");
        $this->service->pullData($io);
        $io->success('The operation completed successfully.');
    }
}
