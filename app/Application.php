<?php

namespace Snippet;

use Snippet\Routing\Router;

class Application {

    private $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function get($path, $resource, $type)
    {
        return $this->router->get($path, $resource, $type);
    }

    public function post($path, $resource, $type)
    {
        return $this->router->post($path, $resource, $type);
    }

    public function put($path, $resource, $type)
    {
        return $this->router->put($path, $resource, $type);
    }

    public function delete($path, $resource, $type)
    {
        return $this->router->delete($path, $resource, $type);
    }

    public function run()
    {
        $success = $this->router->match($_SERVER, $_POST);

        if($success === FALSE) {
            http_response_code(404);
            die("Page not found");
        }

        return $success;
    }
}
