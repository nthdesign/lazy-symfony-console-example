<?php

use NthDesign\LazySymfonyConsoleExample\Container;
use Pimple\Psr11\ServiceLocator;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\CommandLoader\ContainerCommandLoader;

require_once __DIR__ . '/vendor/autoload.php';

/**
 * Instantiate an instance of our Container object. There is nothing special about this container. For instance, it
 * does not know anything about PSR-11!
 */
$container = new Container();

/**
 * A ServiceLocator is Pimple's implementation of the PSR-11 ContainerInterface. Our ServiceLocator exposes only
 * those services (Symfony Console Commands, in our case) we will need in our Symfony Console application.
 */
$serviceLocator = new ServiceLocator($container, ['helloCommand', 'goodbyeCommand']);

/**
 * Pimple's ContainerCommandLoader knows how to load commands from a PSR-11 Container. It also allows us to map command
 * names, like 'hello' to the name of the service which represents the command 'helloCommand'.
 */
$containerCommandLoader = new ContainerCommandLoader(
    $serviceLocator,
    [
        'hello' => 'helloCommand',
        'goodbye' => 'goodbyeCommand'
    ]
);

/**
 * With all of these parts and pieces in-place, we instantiate our Symfony Console Application, set the CommandLoadder,
 * and run the application.
 */
$application = new Application();
$application->setCommandLoader($containerCommandLoader);
$application->run();