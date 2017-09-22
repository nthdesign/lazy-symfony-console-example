<?php
namespace NthDesign\LazySymfonyConsoleExample;

class LazyWhiner {

    public function __construct($instantiator)
    {
        $instantiatorName = get_class($instantiator);
        fwrite(STDOUT, "LazyWhiner says:\n{$instantiatorName} woke me up! :-(\n\n");
    }

    public function whine($runner)
    {
        $runnerName = get_class($runner);
        fwrite(STDOUT, "LazyWhiner says:\n{$runnerName} made me do work! :-(\n\n");
    }
}