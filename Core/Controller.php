<?php

namespace Core;

class Controller
{
	public function getMethod()
	{
		return $_SERVER['REQUEST_METHOD'];
	}

	public function getRequestData()
	{
		switch ($this->getMethod()) {
			case 'POST':
				$data = json_decode(file_get_contents('php://input'));
				if (is_null($data)) 
					$data = $_POST;	
			
			break;
		}

		if (!empty($data)) 
			return	$data;	 		

		$this->returnJson("");
		
	}

	public function returnJson($data = array(), $http_code = 500)
	{		
		header("HTTP/1.0 " . ($http_code));
		header("Content-Type: application/json");	
		
		echo json_encode($data);
		exit;
	}
	
}
