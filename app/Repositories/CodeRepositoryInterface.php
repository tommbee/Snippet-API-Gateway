<?php
	
namespace Snippet\Repositories;

Interface CodeRepositoryInterface {
	
	public function connect();
	public function find(string $id) : CodeSnippet;
	public function getAllByUser();
	
}
	
?>