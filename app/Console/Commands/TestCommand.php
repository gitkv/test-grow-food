<?php namespace App\Console\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TestCommand extends Command
{
    public function configure()
    {
        $this->setName('test')
            ->setDescription('Command description')
            ->setHelp('Help for this command')
            ->addArgument('arg', InputArgument::OPTIONAL, 'test argument');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $arg = $input->getArgument('arg');

        $output->writeln([
            "========================",
            "Test command it's work!",
            "argument \"arg\" = \"$arg\"",
        ]);

        return 0;
    }
}
