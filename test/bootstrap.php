<?php
/**
 * @package assetic-jshint
 *
 * @author Daniel Holzmann <d@velopment.at>
 * @date 08.03.14
 * @time 16:26
 */
use Composer\Autoload\ClassLoader;

$file = __DIR__ . '/../vendor/autoload.php';

if (!file_exists($file)) {
    throw new \RuntimeException('Install dependencies to run test suite. "php composer.phar install --dev"');
}

/** @var ClassLoader  $loader */
$loader = require $file;

$loader->add('Assetic\Test', __DIR__ . '/../vendor/kriswallsmith/assetic/tests');
