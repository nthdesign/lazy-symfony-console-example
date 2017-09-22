<?php
namespace NthDesign\LazySymfonyConsoleExample;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class HelloCommand extends Command {

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
            ->setName('hello')
            ->setDescription('Prints "Hello World" on the command line.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->lazyWhiner->whine($this);
        $output->writeln("Hello World!");
    }
}