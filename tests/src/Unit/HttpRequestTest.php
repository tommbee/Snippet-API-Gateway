<?php

namespace Snippet\Test;

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Handler\MockHandler;
use Snippet\Requests\HttpRequest;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\HandlerStack;

class HttpRequestTest extends TestCase {

  public function testHttpRequest()
  {
    $mock = new MockHandler([
        new Response(200, ['X-Foo' => 'Bar']),
        new Response(202, ['Content-Length' => 0]),
        new RequestException("Error Communicating with Server", new Request('GET', 'test'))
    ]);
    $handler = HandlerStack::create($mock);
    $client = new Client(['handler' => $handler]);

    $request = new HttpRequest($client);
    $request->setUrl('/');
    $request->sendRequest();
    $this->assertContains(
      'Content-type: text/html; charset=UTF-8', \xdebug_get_headers()
    );
  }


}
