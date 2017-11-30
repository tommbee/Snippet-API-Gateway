<?php

namespace Snippet\Requests;

interface RequestInterface {

  public function setUrl($route);
  public function setRequestBody($data);
  public function sendRequest($method);

}

