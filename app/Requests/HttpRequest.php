<?php

namespace Snippet\Requests;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Stream\Stream;
use GuzzleHttp\Stream\Utils;

class HttpRequest extends SnippetRequest {

  protected $client;

  function __construct(Client $client)
  {
    $this->client = $client;
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
