<?php

namespace Snippet\Requests;

abstract class SnippetRequest
{

    protected $url;
    protected $data;

    public function setUrl($route)
    {
        $this->url = $route;
    }

    public function setRequestBody($data)
    {
        $this->data = $data;
    }

    abstract public function sendRequest($method = "GET");
    

}
