<?php

namespace Snippet\Test;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Yaml\Yaml;
use Snippet\Exceptions\ConfigurationException;
use DI\ContainerBuilder;

class AppRouteTest extends TestCase {

  public function testAppRoutes()
  {
    $routes = Yaml::parse(file_get_contents(__DIR__ . '/../example/example.yml'));
    $app = ContainerBuilder::buildDevContainer()->get('Snippet\Application');
    foreach ($routes as $endpoint => $route) {
      $method = $route['method'];
      $app->$method($endpoint, $route['route'], $route['type']);
    }
    $this->assertArrayHasKey('/search', $app->router->routes['GET'][0]);
  }


}
