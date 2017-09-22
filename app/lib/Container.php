<?php
namespace NthDesign\LazySymfonyConsoleExample;

class Container extends \Pimple\Container {

    public function __construct()
    {
        parent::__construct();

        $this['helloCommand'] = function () {
            $lazyWhiner = new LazyWhiner($this);
            return new HelloCommand($lazyWhiner);
        };

        $this['goodbyeCommand'] = function () {
            $lazyWhiner = new LazyWhiner($this);
            return new GoodbyeCommand($lazyWhiner);
        };
    }
}