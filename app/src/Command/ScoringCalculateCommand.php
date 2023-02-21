<?php

declare(strict_types=1);

namespace App\Command;

use App\Repository\CustomerRepository;
use App\Service\ConsoleOutput\CustomerOutput;
use App\Service\Customer\CustomerScoreUpdater;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:scoring:calculate',
    description: 'recalcualate user score',
)]
class ScoringCalculateCommand extends Command
{
    public function __construct(
        private CustomerRepository $repository,
        private CustomerScoreUpdater $customerScoreUpdater,
        private CustomerOutput $customerOutput,
        string $name = null
    ) {
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this->addArgument('id', InputArgument::OPTIONAL, 'customer id');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $id = $input->getArgument('id');

        $io = new SymfonyStyle($input, $output);

        if ($id) {
            $this->customerOutput->printCustomerInfo(
                $this->customerScoreUpdater->updateCustomerScore(
                    $this->repository->find($id),
                    true
                ),
                $io
            );
        } else {
            $this->customerOutput->printCustomersInfo(
                $this->customerScoreUpdater->updateCustomersScore(
                    $this->repository->findAll(),
                    true
                ),
                $io
            );
        }

        return Command::SUCCESS;
    }
}
