# Example: Lazy-Loaded Symfony Console Commands

This repository demonstrates how to create Symfony Console commands that are loaded lazily. This is useful in 
situations when a subset of your Symfony Console commands depend on resource-intensive dependencies while other
commands in the same Symfony Console application do not. 

## PHP Tools
We'll be using several tools in this example:

1. Composer - Dependency Manager for PHP  
   https://getcomposer.org/
1. Pimple - Dependency Injection Container for PHP  
   https://pimple.symfony.com/
1. Symfony Console Component - Command Line Interface Library for PHP
   https://symfony.com/doc/current/components/console.html
   
## How Do Lazy-Loaded Commands Work?
The Symfony Console component supports lazy-loaded commands as-of version 3.4. Most of the "magic" happens when we 
define and instantiate our Symfony Console Application. Take a look at the `app.php` file for details: 
```php
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
```

### Lazy Whiner!

Our `LazyWhiner` class exists to show when commands are instantiated and executed. The LazyWhiner will whine at us when
we make it do work! When you run the `hello` and `goodbye` commands at the end of this README, you'll see!
   
## Composer
We'll use Composer to install all of our PHP dependencies. We only need to do this:
1. The first time we clone this project, before building the Docker image.
1. Any time we make changes to the composer.json file, or if we update the composer.lock file.

You don't even need to install Composer on your development computer! You can run it directly from DockerHub. After 
cloning this repository, run the following command from the root directory of this project:
```bash
docker run --rm --interactive --tty --volume ${PWD}/app:/app composer install
```

## Docker
This example project uses Docker to launch a container environment for testing.

### Installing Docker
If you need to install Docker, click here: https://www.docker.com/get-docker

### Building the Docker Image for this Example Project
You'll notice a Dockerfile in this example project. That file is used by Docker to create a Docker _image_. Let's use 
Docker to create an image for our project. On your development computer, enter the following commands on the command
line:
```bash
docker build -t lazy-symfony-console-image .
``` 

### Running the Docker Container for this Example Project
Once you have a Docker image, you can run it as a containerized application with one CLI command. Using the `docker run` 
command, we can pass in a specific command to run. We'll pass in `php app.php hello` and `php app.php goodbye` to try
out both of our Symfony Console commands.
```bash
docker run -it --rm --name lazy-symfony-console-app lazy-symfony-console-image php app.php hello

docker run -it --rm --name lazy-symfony-console-app lazy-symfony-console-image php app.php goodbye
```