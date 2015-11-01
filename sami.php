<?php

$dir = __DIR__ . '/src';

$iterator = Symfony\Component\Finder\Finder::create()
    ->files()
    ->name('*.php')
    ->exclude('DataFixtures')
    ->exclude('Resources')
    ->exclude('Tests')
    ->in($dir);

$options = [
    'theme'                => 'default',
    'title'                => 'Elcodi API Documentation',
    'build_dir'            => __DIR__ . '/../gh-pages',
    'cache_dir'            => __DIR__ . '/../gh-pages_cache',
];

$sami = new Sami\Sami($iterator, $options);

return $sami;
