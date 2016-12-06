Fonck Toolbox
===============================

Framework Agnostic Services to model php applications.

[![Build Status](https://travis-ci.org/joselfonseca/fonck-toolbox.svg?branch=master)](https://travis-ci.org/joselfonseca/fonck-toolbox)
[![Code Coverage](https://scrutinizer-ci.com/g/joselfonseca/fonck-toolbox/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/joselfonseca/fonck-toolbox/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/joselfonseca/fonck-toolbox/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/joselfonseca/fonck-toolbox/?branch=master)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/1d69f596-c9b4-419d-9f66-0da7e7770742/small.png)](https://insight.sensiolabs.com/projects/1d69f596-c9b4-419d-9f66-0da7e7770742)

#Instalation

To install this package run

```bash
    composer require joselfonseca/fonck-toolbox
```

#Usage

The easiest way to use the package is by calling the Services Factory Class to build the services.

```php
use Joselfonseca\FonckToolbox\ServicesFactory;
$services = new ServicesFactory();
```
Once you have the services, you have access to 2 basic services to start modeling your business.

```php
    // Tactician Command Bus
    $services->bus;
    // Symfony Event Dispatcher
    $services->event
```
#Tactician Command Bus

The package gives you an implementation of the Tactician command bus by Ross Tuck in the PHP League, you can dispatch commands, validate them and handle them using this package in a very simple way.
 
First you need to create a command class that is a simple DTO encapsulating the information for the command, the constructor parameters will be mapped with the input given to the service that will execute the command

```php
    <?php
    
    namespace App\Commands;
    
    class CreatePostCommand
    {
        
        public $title;
        
        public $body;
        
        public function __construct($title, $body)
        {
            $this->title = $title;
            $this->body = $body;
        }
        
    }

```

Having the command, you will need a Handler taking the command class name and adding  "Handler" at the end, also it should implement the interface `Joselfonseca\FonckToolbox\Bus\HandlerInterface`, meaning the handler for this command should be

```php
    <?php
    
    namespace App\Commands;
    
    use Joselfonseca\FonckToolbox\Bus\HandlerInterface;
    
    class CreatePostCommandHandler implements HandlerInterface
    {
    
        protected $container;
        
        /**
         * Constructor that receives the League Container
         * @param Container $container
         */
        public function __construct(Container $container)
        {
            $this->container = $container;
        }
        
        public function handle($command)
        {
            // Do your thing
        }
        
    }
```

Having this 2 classes, you can now use the service to dispatch the command and execute the handler, keep in mind that the second parameter in the bus expects an array with the data to map to the command, if you fail to pass the necessary data you will get an InvalidArgumentException exception.

```php
    <?php
    $services = new \Joselfonseca\FonckToolbox\ServicesFactory();
    $result = $services->bus->dispatch(\App\Commands\CreatePost::class, [
        'title' => 'Post Title',
        'body' => 'Loren ipsun and some other stuff...'
    ]);
```

Now `$result` will be anything you return from the handler. For more information about the command bus, please visit [http://tactician.thephpleague.com/](http://tactician.thephpleague.com/)

##Middleware

The command bus receives a 3rd argument which is an array with the class names for middleware to be executed before the command is handled, this class have to implements the interface `Joselfonseca\FonckToolbox\Bus\MiddlewareInterface` which will have a constructor that received the league container so you can resolve classes and implementations, this interface extends the Tactician Middleware interface, for more information about Middleware please visit [http://tactician.thephpleague.com/middleware/](http://tactician.thephpleague.com/middleware/)

```php
    <?php
    
    namespace App\Commands\Middleware;
    
    use Joselfonseca\FonckToolbox\Bus\MiddlewareInterface as Middleware;
    
    class SetTheSlugMiddleware implements Middleware
    {
        
        protected $container;
        
        /**
         * The League Container
         * @param Container $container
         */
        public function __construct(Container $container)
        {
            $this->container = $container;
        }
        
        /**
         * @param object $command
         * @param callable $next
         *
         * @return mixed
         */
        public function execute($command, callable $next)
        {
            $command->slug = generateSlug($command->title);
            return $next($command);
        }
        
    }
```

Once you have the middleware, you can pass it to the 3rd argument in the command bus.

```php
    <?php
    $services = new \Joselfonseca\FonckToolbox\ServicesFactory();
    $result = $services->bus->dispatch(\App\Commands\CreatePost::class, [
        'title' => 'Post Title',
        'body' => 'Loren ipsun and some other stuff...'
    ], [
    \App\Commands\Middleware\SetTheSlugMiddleware::class
    ]);
```

##Events

After the command has been handled, you may want to fire an event to be able to extend or respond to the action. For that Fonck Toolbox provides some interfaces and it ships with a Symfony Event Dispatcher Adapter.

```php
    <?php
    
    namespace App\Commands;
    
    use Joselfonseca\FonckToolbox\Bus\HandlerInterface;
    
    class CreatePostCommandHandler implements HandlerInterface
    {
    
        protected $event;
        protected $container;
        
        /**
         * The League Container
         * @param Container $container
         */
        public function __construct(Container $container)
        {
            $this->container = $container;
            $this->event = $this->container->event;
        }
        
        public function handle($command)
        {
            // this is just an example using a repository to create the post
            $post = PostRepository::create((array) $command);
            // after you do your thing fire and event before returning the post or what ever you want to return
            $this->event->fire('post.created', [
                'command' => $command,
                'post' => $post
            ]);
            return $post;
        }
        
    }
```

The second parameter accepts an array which will be converted into a event class that will be populated with the data.

##Listeners

Somewhere in your code you can add a listener for the event using the event service.

```php
   <?php
   $services = new \Joselfonseca\FonckToolbox\ServicesFactory();
   $services->event->listen('post.created', \App\Listeners\SendEmail::class);
```

Your listener class should have a handle method that will receive the event that was fired.

```php
    <?php
    
    namespace App\Listeners;
    
    class SendEmail 
    {
        
        public function handle($event)
        {
            //handle the event
            $data = $event->getEventData();
        }
    }
```

For more information about the event dispatcher please visit [http://symfony.com/doc/current/cookbook/event_dispatcher/index.html](http://symfony.com/doc/current/cookbook/event_dispatcher/index.html)

##Container

This package uses a DI container from the php League, if you want to get the container instance you can do it from the factory

```php
    $services = new \Joselfonseca\FonckToolbox\ServicesFactory();
    $container = $services->container;
```

For more information about the Container please visit [http://container.thephpleague.com/](http://container.thephpleague.com/)

#Tests

To run the test in this package, navigate to the root folder of the project and run

```bash
    composer install
```
Then

```bash
    vendor/bin/phpunit
```

#Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

#Security

If you discover any security related issues, please email jose at ditecnologia dot com instead of using the issue tracker.

#Credits

- [Jose Luis Fonseca](https://github.com/joselfonseca)
- [All Contributors](../../contributors)

#License

The MIT License (MIT). Please see [License File](license.md) for more information.

