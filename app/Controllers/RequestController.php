<?php

namespace Snippet\Controllers;

use Snippet\Requests\HttpRequest;
use DI\ContainerBuilder;

class RequestController {

	protected $request;

	public function sendHttpRequest($route, $method, $args, $body = [])
	{
		$request = ContainerBuilder::buildDevContainer()->get('Snippet\Requests\HttpRequest');

		if(!empty($args)) {
			$route .= '?' . http_build_query($args);
		}

		$request->setUrl($route);
		$request->setRequestBody($body);
		return $request->sendRequest($method);
	}

}

?>
