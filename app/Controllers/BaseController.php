<?php

namespace Snippet\Controllers;

Class BaseController {
	
	function __construct()
	{ 
		
    }
    
    public function render($templateName, array $parameters = array())
    {
	    
		$loader = new \Twig_Loader_Filesystem('Views');
  
  		$twig = new \Twig_Environment($loader);
  		
		$template = $twig->load($templateName);
		
        return $template->render($parameters);
    }
	
}

?>