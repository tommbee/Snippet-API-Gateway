<?php

namespace Snippet\Requests;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Stream\Stream;
use GuzzleHttp\Stream\Utils;

class HttpRequest implements RequestInterface {

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

  public function sendRequest($method = "GET")
  {

    $options['stream'] = true;

    if(!empty($this->data)) {
      $options['body'] = $this->data['data'];
      $options['headers'] = ['Content-Type' => $this->data['type']];
    }

    $client = new Client();

    $response = $client->request($method, $this->url, $options);

    # Response
    header("Content-Type:{$response->getHeader('Content-Type')[0]}");

    $body = $response->getBody();
    while (!$body->eof()) {
        echo $body->read(1024);
    }

  }


}
