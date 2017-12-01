<?php

namespace Snippet\Requests;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Stream\Stream;
use GuzzleHttp\Stream\Utils;

class HttpRequest implements RequestInterface {

  protected $url;
  protected $data;
  protected $client;

  function __construct(Client $client)
  {
    $this->client = $client;
  }

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

    $response = $this->client->request($method, $this->url, $options);

    # Response
    if(!is_null($response->getHeader('Content-Type')) && isset($response->getHeader('Content-Type')[0])) {
      header("Content-Type:{$response->getHeader('Content-Type')[0]}");
    }

    $body = $response->getBody();
    while (!$body->eof()) {
        echo $body->read(1024);
    }

  }


}
