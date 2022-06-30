<?php

namespace Controllers;

use \Core\Controller;

class SearchController extends Controller
{

	/**
	 * É a principal função do controller. Recebe a palavra e através de outras funções processa  o resultado e retorna.     
	 * @param string getRequestData()->text - contém a palavra de entrada via post 
	 * @return string
	 */
	public function search()
	{
		if (empty($this->getRequestData()->text)) $this->returnJson(["erro" => "Texto inválido!"], 500);

		$numerosRomanosArray = $this->getNumerosRomanos($this->getRequestData()->text);

		$maiorValor = $this->getMaiorValor($numerosRomanosArray);

		$this->returnJson(["number" => $maiorValor['maiorRoman'], "value" => $maiorValor['maiorInt']], 200);
	}


	/**
	 * Recebe uma string e retorna em um array todos os números romanos encontramos nela     
	 * @param string $text contém o texto que será usado para encontrar os números romanos 
	 * @return array
	 */
	function getNumerosRomanos($text)
	{
		$textArray = str_split($text);
		$numerosRomanos = 'IVXLCDM';
		$sequencia = 0;
		$romanos   = [];

		foreach ($textArray as $row) {

			if (strstr($numerosRomanos, $row)) {

				if ($sequencia == 0) {
					$romanos[] = $row;
				} else {
					$index = array_key_last($romanos);
					$romanos[$index] .= $row;
				}

				$sequencia++;
			} else {
				$sequencia = 0;
			}
		}

		return $romanos;
	}

	/**
	 * Recebe um array com números romanos e retorna o maior entre eles   
	 * @param array $numerosRomanosArray contém o array com números romanos 
	 * @return array
	 */
	function getMaiorValor($numerosRomanosArray)
	{
		$maiorInt 	= 0;
		$maiorRoman = '';

		foreach ($numerosRomanosArray as $row) {

			$valor = $this->romanoParaInt($row);

			if ($valor > $maiorInt) {
				$maiorInt   = $valor;
				$maiorRoman = $row;
			}
		}

		return ["maiorInt" => $maiorInt, "maiorRoman" => $maiorRoman];
	}

	/**
	 * Recebe um número romano, converte para inteiro, e retorna o valor convertido   
	 * @param string $valorRomano contém o número romano que será convertido
	 * @return int
	 */
	function romanoParaInt($valorRomano)
	{
		$valorRomano   = str_split($valorRomano);
		$valoresPadrao = ['I' => '1', 'V' => '5', 'X' => '10', 'L' => '50', 'C' => '100', 'D' => '500', 'M' => '1000'];

		$valorInt = 0;

		foreach ($valorRomano as $key => $row) {

			if ($valoresPadrao[$row] >= (array_key_exists($key + 1, $valorRomano) ? $valoresPadrao[$valorRomano[$key + 1]] : 0)) {
				$valorInt = $valorInt + $valoresPadrao[$row];
			} else {
				$valorInt = $valorInt - $valoresPadrao[$row];
			}
		}
		return $valorInt;
	}
}
