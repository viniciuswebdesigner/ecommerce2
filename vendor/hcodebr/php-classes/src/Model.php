<?php 

namespace Hcode;

class Model {

	private $values = [];

	public function __call($name, $args)
	{

		$method = substr($name, 0, 3);  //Pega as 3 primeiras letras (get ou set)
		$fieldName = substr($name, 3, strlen($name));  //Pega da 3ª até o final

		switch ($method)
		{

			case "get":
				return (isset($this->values[$fieldName])) ? $this->values[$fieldName] : NULL;  //retorna getNome
			break;

			case "set":
				$this->values[$fieldName] = $args[0];  //retorna setNome
			break;

		}

	}

	public function setData($data = array())
	{

		foreach ($data as $key => $value) {
			
			$this->{"set".$key}($value);  //pega o valor de cada linha para cada coluna do banco de dados

		}

	}

	public function getValues()
	{

		return $this->values;

	}

}

 ?>