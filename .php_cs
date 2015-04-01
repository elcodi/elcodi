<?php

$config = Symfony\CS\Config\Config::create()
    // use SYMFONY_LEVEL:
    ->level(Symfony\CS\FixerInterface::SYMFONY_LEVEL)
    // and extra fixers:
    ->fixers([
        'concat_with_spaces',
        'multiline_spaces_before_semicolon',
        'short_array_syntax',
        '-remove_lines_between_uses',
    ]);

if (null === $input->getArgument('path')) {
    $config
        ->finder(
            Symfony\CS\Finder\DefaultFinder::create()
                ->in('src/')
        );
}

return $config;
