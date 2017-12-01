<?php

namespace Snippet\Routing;

use Snippet\Controllers\RequestController;

class Router {

    private $request_controller;

    function __construct(RequestController $request_controller)
    {
        $this->request_controller = $request_controller;
    }

    public $routes = [
        'GET'    => [],
        'POST'   => [],
        'PUT'    => [],
        'DELETE' => [],
    ];

    public function any($path, $handler){
        $this->addRoute('GET', $path, $handler);
        $this->addRoute('POST', $path, $handler);
        $this->addRoute('PUT', $path, $handler);
        $this->addRoute('DELETE', $path, $handler);
    }

    public function get($path, $handler, $type){
        $this->addRoute('GET', $path, $handler, $type);
    }

    public function post($path, $handler, $type){
        $this->addRoute('POST', $path, $handler, $type);
    }

    public function put($path, $handler, $type){
        $this->addRoute('PUT', $path, $handler, $type);
    }

    public function delete($path, $handler, $type){
        $this->addRoute('DELETE', $path, $handler, $type);
    }

    protected function addRoute($method, $path, $handler, $type){
        array_push($this->routes[$method], [$path => ['route' => $handler, 'type' => $type] ]);
    }

    public function match(array $server = [])
    {

        $requestMethod = (isset($server['REQUEST_METHOD'])) ? $server['REQUEST_METHOD'] : null;
        $requestUri    = (isset($server['REQUEST_URI'])) ? $server['REQUEST_URI'] : null;
        $requestBody = [];
        if( isset($server['CONTENT_TYPE']) ) {
            $rawData = file_get_contents("php://input");
            $requestBody['type'] = $server['CONTENT_TYPE'];
            $requestBody['data'] = $rawData;
        }

        $restMethod = $this->getRestfullMethod($server);

        if (null === $restMethod && !in_array($requestMethod, array_keys($this->routes))) {
            return false;
        }

        $method = $restMethod ?: $requestMethod;

        foreach ($this->routes[$method]  as $resource) {

            $args    = $this->getArgs($requestUri);
            $route   = key($resource);
            $handler = reset($resource)['route'];
            $type = reset($resource)['type'];
            $requestUri = $this->getUrl($requestUri);

            if(!preg_match("#^$route$#", $requestUri)) {
                // No matches
                unset($this->routes[$method]);
                continue;
            }

            return $this->requestDispatcher(['route' => $handler, 'method' => $method, 'args' => $args, 'type' => $type, 'body' => $requestBody]);

          }

          return false;
    }

    private function requestDispatcher($resource) {

        $route      = $resource['route'];
        $method     = $resource['method'];
        $args       = $resource['args'];
        $type       = $resource['type'];
        $body       = $resource['body'];

        switch ($type) {
            case 'http':
                return $this->request_controller->sendHttpRequest($route, $method, $args, $body);
                break;
            default:
                return $this->request_controller->sendHttpRequest($route, $method, $args, $body);
                break;
        }

    }

    protected function getRestfullMethod($postVar)
    {
        if(array_key_exists('REQUEST_METHOD', $postVar)){
        	$method = strtoupper($postVar['REQUEST_METHOD']);
            if(in_array($method, array_keys($this->routes))){
                return $method;
            }
        }
    }

    public function getUrl($url)
    {
        $parts = parse_url($url);
        return $parts['path'];
    }

    protected function getArgs($url)
    {
        $query = [];
        $parts = parse_url($url);

        if(isset($parts['query'])) {
            parse_str($parts['query'], $query);
        }

        return $query;
    }

}
