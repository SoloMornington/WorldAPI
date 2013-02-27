WorldAPI
========

What is it?
-----------

WorldAPI is a PHP consumer of the World API from Second Life.

SL's World API gives the aspiring web scraper a lot of info about Second Life residents, places, and groups.

WorldAPI (no space... see?) wraps all that up in a handy PHP object.

The Second Life World API documentation is here: https://wiki.secondlife.com/wiki/World_API

WorldAPI needs: cURL and DOM PHP extensions, and PHP 5 (since it's a set of classes).

Installation
------------

WorldAPI is a packagist package: https://packagist.org/packages/mornington/worldapi

You can use it with your project through Composer: http://getcomposer.org/

The standard way to install composer is:

- `cd` to your project directory.

- Install composer: `curl -s https://getcomposer.org/installer | php`

- Have composer generate a generic composer.json file: `php ./composer.phar init`

- Tell composer to install/update dependencies: `php ./composer.phar -v -o update`

To include WorldAPI in your project, add something like this to your dependencies, in composer.json:

    "require": {
      "mornington/worldapi": "dev-master"
    }


How do you use it?
------------------

The `demo.php` file has some example usage.

Basically, instantiate one of the WorldAPI subclasses, passing a UUID as the single argument.

Then call the worldAPI() function on that object and you'll have a handy array with the various meta fields as keys.

Here's how you'd show Solo Mornington's maturity rating:

    $resident = new WorldAPIResident('6d286553-59ae-409a-887d-ee75df67b834');
    $data = $resident->worldAPI();
    echo $data['mat'];

How is it licensed?
-------------------

It's happy and friendly and GNU licensed.

Where does it live?
-------------------

The official repository for WorldAPI is on github. Of course, everyone's welcome to join in with bug reports and pull requests. 

https://github.com/SoloMornington/WorldAPI

Who are you?
------------

I'm Solo Mornington on Second Life. I'm working on this as part of a project for the Linden Endowment For The Arts. http://www.lea-sl.org

You can contact me through my github page, or on Second Life.

