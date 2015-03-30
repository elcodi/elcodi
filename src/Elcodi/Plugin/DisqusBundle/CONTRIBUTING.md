Contributing
------------

This project follows some standards. If you want to collaborate, please ensure
that your code fulfills these standards before any Pull Request.

``` bash
composer.phar update
bin/php-cs-fixer fix
bin/php-formatter formatter:use:sort src/
bin/php-formatter formatter:header:fix src/
```

There is also a policy for contributing to this project. Pull requests must
be explained step by step to make the review process easy in order to
accept and merge them. New features must come paired with Unit and/or Functional
tests.
