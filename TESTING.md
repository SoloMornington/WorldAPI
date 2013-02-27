WorldAPI Testing
================

How do you run the tests?
-------------------------

WorldAPI uses PHPUnit for testing, managed by Composer.

- Install Composer: `curl https://getcomposer.com/installer | php`
- Run Composer: `php ./composer.phar -v -o install`
- Run the tests: `./vendor/bin/phpunt`

Note that WorldAPI makes use of Travis continuous integration through Github. This means that any pull request or push to the repo will run the tests. It also means you shouldn't change `.travis.yml`. :-)

Some Travis info here: http://about.travis-ci.org/docs/user/getting-started/

