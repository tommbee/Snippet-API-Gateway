<?php

session_start();
require __DIR__ . '/vendor/autoload.php';

use Symfony\Component\Yaml\Yaml;
use Snippet\Exceptions\ConfigurationException;
use DI\ContainerBuilder;

if(!file_exists(__DIR__ . '/app/Config/routes.yml')) {
  throw new ConfigurationException('Route configuration file not found');
}

$routes = Yaml::parse(file_get_contents(__DIR__ . '/app/Config/routes.yml'));

$app = ContainerBuilder::buildDevContainer()->get('Snippet\Application');

foreach ($routes as $endpoint => $route) {
  $method = $route['method'];
  $app->$method($endpoint, $route['route'], $route['type']);
}

$app->run();
