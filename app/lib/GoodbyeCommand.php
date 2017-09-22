<?php
namespace NthDesign\LazySymfonyConsoleExample;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GoodbyeCommand extends Command {

    /** @var LazyWhiner */
    private $lazyWhiner;

    public function __construct(LazyWhiner $lazyWhiner)
    {
        parent::__construct();
        $this->lazyWhiner = $lazyWhiner;
    }

    protected function configure()
    {
        $this
            ->setName('goodbye')
            ->setDescription('Prints "Goodbye World" on the command line.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->lazyWhiner->whine($this);
        $output->writeln("Goodbye World!");
    }
}