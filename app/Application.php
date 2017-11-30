<?php

namespace Snippet;

use Snippet\Routing\Router;

Class Application implements \ArrayAccess {
      
    public function __construct()
    {
        $this['route'] = $this->store(function() {
            return new Router;
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


    public function get($path, $resource){
        return $this['route']->get($path, $resource);
    }

    public function post($path, $resource){
        return $this['route']->post($path, $resource);
    }

    public function put($path, $resource){
        return $this['route']->put($path, $resource);
    }

    public function delete($path, $resource){
        return $this['route']->delete($path, $resource);
    }

    private function controllerDipatcher($resource)
    {
        $controller = $resource['controller']; 
        $method     = $resource['method']; 
        $args       = $resource['args']; 

        $controller = "Snippet\Controllers\\".$resource['controller']; 
        
        if(!class_exists($controller)){
			throw new \Exception("controller $controller does not exist");
        }

        $controller = new $controller; 
        if(!method_exists($controller, $method)){
			throw new \Exception("method $method does not exist in $controller"); 
		}
        
		echo (new $controller)->$method($args, $this);
		
    }


    public function run()
    {
        $resource = $this['route']->match($_SERVER, $_POST);
        
        if(is_array($resource)){
            $this->controllerDipatcher($resource);
        }
    }
}
