<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');




if ( ! function_exists('objectToArray'))
{
	function objectToArray($d)
	{


		if (is_object($d))
		{
			// Gets the properties of the given object
			// with get_object_vars function
			$d = get_object_vars($d);
		}


		if (is_array($d))
		{
			/*
			* Return array converted to object
			* Using __FUNCTION__ (Magic constant)
			* for recursive call
			*/
			return array_map(__FUNCTION__, $d);

			}else {
			// Return array
			return $d;
		}

	}
}


/**
 * Desetea en el array pasado por parámetro, los que tengan el mismo número en el campo dado.
 * El campo pasado debe ser int(), si no de otra manera no funciona.
 **/
if ( ! function_exists('unsetRepeats'))
{
	function unsetRepeats( $array, $campo)
	{
		$resultados 		= array();
		$array_campos 	= array(); // Va a tener en una primera instancia, todos los valores del campo dado en el parámetro, que tenga el array del parámetro.

		foreach($array AS $k=>$arr)
		{
			echo 'id_clave' , $arr[$campo] , '<br />';

			foreach($resultados AS $res)
			{
				if (isset($res[$campo]))
				{
					if ($arr[$campo] != $res[$campo])
					{
						array_push($resultados, $array[$k]);

					}
				}
			}

			// if ( !in_array($arr[$campo], $resultados))
			// {
			// 	// $resultados[] = $arr[$k];
			// }

		}


		//
		// Debagueo un objeto / arreglo / variable
		//
		echo ' <br/> <div style="font-weight: bold; color: green;"> $resultados: </div> <pre>' ;
		echo '<div style="color: #3741c6;">';
		if(is_array($resultados)) {
		    print_r($resultados);
		}else {
		var_dump($resultados);
		}
		echo '</div>';
		echo '</pre>';
		die('--FIN--DEBUGEO----');



		foreach($array_campos AS $arr_potables)
		{

		}
		//
		// Debagueo un objeto / arreglo / variable
		//
		echo ' <br/> <div style="font-weight: bold; color: green;"> $array_campos: </div> <pre>' ;
		echo '<div style="color: #3741c6;">';
		if(is_array($array_campos)) {
		    print_r($array_campos);
		}else {
		var_dump($array_campos);
		}
		echo '</div>';
		echo '</pre>';
		die('--FIN--DEBUGEO----');



		return true;
	}
}



































