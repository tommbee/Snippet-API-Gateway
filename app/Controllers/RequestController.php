<?php

namespace Snippet\Controllers;

use Snippet\Requests\HttpRequest;

class RequestController {

	protected $request;

	public function sendHttpRequest($route, $method, $args, $body = [])
	{

		$request = new HttpRequest;

		if(!empty($args)) {
			$route .= '?' . http_build_query($args);
		}

		$request->setUrl($route);
		$request->setRequestBody($body);
		return $request->sendRequest($method);
	}

}

?>
