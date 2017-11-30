<?php

namespace Snippet;

use Snippet\Routing\Router;
use Snippet\Controllers\RequestController;

class Application implements \ArrayAccess {

    public function __construct()
    {
        $this['route'] = $this->store(function() {
            return new Router(new RequestController);
        });
    }

     public function offsetUnset($offset){}

    public function offsetGet($offset)
    {
        if(array_key_exists($offset, $this->container) &&
            is_callable($this->container[$offset])){
            return $this->container[$offset]();
        }
        return $this->container[$offset];
    }

    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->container);
    }

    public function offsetSet($offset, $value)
    {
        if(strpos($offset, ':')){
            list($index, $subset) = explode(':', $offset, 2);
            $this->container[$index][$subset] = $value;
        }

        $this->container[$offset] = $value;
    }

    public function store(Callable $callable)
    {
        return function () use ($callable){
            static $object;
            if(null == $object){
                $object = $callable($this->container);
            }
            return $object;
        };
    }

    public function get($path, $resource, $type)
    {
        return $this['route']->get($path, $resource, $type);
    }

    public function post($path, $resource, $type)
    {
        return $this['route']->post($path, $resource, $type);
    }

    public function put($path, $resource, $type)
    {
        return $this['route']->put($path, $resource, $type);
    }

    public function delete($path, $resource, $type)
    {
        return $this['route']->delete($path, $resource, $type);
    }

    public function run()
    {
        $success = $this['route']->match($_SERVER, $_POST);

        if($success === FALSE) {
            http_response_code(404);
            die();
        }
    }
}
