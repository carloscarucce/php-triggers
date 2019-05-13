# php-triggers
Create events and listeners using php

## Instalation

All you have to do is run *composer require carloscarucce/php-triggers* or add the following to your composer.json:

```
{
  "require": {
    "carloscarucce/php-triggers": "1.*"
  }
}
```



## How to use

First you have to setup a listener to your event.

```php
use PhpTriggers\EventListener;

class LambdaFunctionsListener extends EventListener
{
    public function listen(Event $event, ...$data)
    {
        list($name, $lastName) = $data;
        
        echo "Welcome $name $lastName !";
    }

    /**
     * LambdaFunctionsListener constructor.
     */
    public function __construct()
    {
        $this->listensTo('check-in');
    }
}
```

Then all you have to do is trigger that event whenever you want to:

```php
use PhpTriggers\Event;

Event::create('check-in', [
    'name' => 'John',
    'lastName' => 'Doe'
])->trigger();
```
