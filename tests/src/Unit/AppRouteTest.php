<?php

namespace Snippet\Test;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Yaml\Yaml;
use Snippet\Exceptions\ConfigurationException;

class AppRouteTest extends TestCase {

  public function testAppRoutes()
  {
    $routes = Yaml::parse(file_get_contents(__DIR__ . '/../example/example.yml'));
    $app = new \Snippet\Application();
    foreach ($routes as $endpoint => $route) {
      $method = $route['method'];
      $app->$method($endpoint, $route['route'], $route['type']);
    }
    $this->assertArrayHasKey('/search', $app['route']->routes['GET'][0]);
  }


}
