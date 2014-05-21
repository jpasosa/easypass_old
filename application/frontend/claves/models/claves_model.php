<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Claves_model extends CI_Model
{



	public function __contruct()
	{
		parent::__construct();

	}



	/**
	 * Validación de la categoría
	 **/
	public function validate($clave)
	{

		$errores = array();

		if($clave['titulo'] == '') {
			$errores['titulo'] = 'Debe ingresar el titulo';
		}

		return $errores;
	}


	/**
	 * Inserto una categoría
	 **/
	public function insert($clave)
	{
		try {

			$this->db->trans_start();

			$tags = $clave['tags'];
			unset($clave['tags']);



			if($clave['clave'] != '') {
				$this->db->set('clave',"PASSWORD(".$this->db->escape($clave['clave']). ")",false);
			}
			unset($clave['clave']);

			$this->db->insert('claves', $clave);
			if ($this->db->affected_rows()) {
				$id_clave = $this->db->insert_id();
				foreach( $tags AS $tg)
				{
					$tags_claves['id_tag'] 	= $tg;
					$tags_claves['id_clave'] = $id_clave;
					$this->db->insert('tags_claves', $tags_claves);
				}
			} else {
				return 0;
			}

			$this->db->trans_complete();

			if ($this->db->trans_status() === FALSE)
			{
				return 0;
			} else {
				return $id_clave;
			}


		} catch (Exception $e) {
			echo $e->getMessage();
			exit(1);
		}

	}


	public function getAll()
	{

		try {

			$sql 	= "SELECT * FROM categorias C ";
			$q 		= $this->db->query($sql);
			$categorias = $q->result_array();

			return $categorias;

		} catch (Exception $e) {
			echo $e->getMessage();
			exit(1);
		}

	}


	public function search($searching = NULL)
	{
		try {

			$words 		= $searching['words'];
			$id_categoria 	= $searching['id_categoria'];

			if ($id_categoria == 0) {
				$search_categoria = " ";
			} else {
				$search_categoria = " AND C.id_categoria=" . $id_categoria;
			}

			$words_arr 		= explode(" ", $words);
			$quanty_words 	= count($words_arr);
			$cont 				= 1; // Inicializo contador.

			do {

			$cont++;
			} while ( $cont <= $quanty_words);

			foreach ($words_arr AS $word)
			{
				$sql = 'SELECT * FROM claves C
							INNER JOIN categorias CAT
								ON C.id_categoria=CAT.id_categoria
							INNER JOIN tags_claves TC
								ON C.id_clave=TC.id_clave
							INNER JOIN tags T
								ON TC.id_tag=T.id_tag
						WHERE T.nombre_tag LIKE "%' . $word . '%" ' . $search_categoria ;

				$result = $this->db->query($sql);
				$result = $result->result_array();
			}


			//
			// Debagueo un objeto / arreglo / variable
			//
			echo ' <br/> <div style="font-weight: bold; color: green;"> $result: </div> <pre>' ;
			echo '<div style="color: #3741c6;">';
			if(is_array($result)) {
			    print_r($result);
			}else {
			var_dump($result);
			}
			echo '</div>';
			echo '</pre>';
			die('--FIN--DEBUGEO----');

		} catch (Exception $e) {
			echo $e->getMessage();
			exit(1);

		}
	}

	// public function update($categoria, $id_categoria)
	// {
	// 	try {

	// 		$this->db->where('id_categoria', $id_categoria);
	// 		$this->db->update('categorias', $categoria);

	// 		return true;

	// 	} catch (Exception $e) {
	// 		echo $e->getMessage();
	// 		exit(1);
	// 	}

	// }




	// public function eraseCategoria( $id_categoria )
	// {
	// 	try {

	// 		 $this->db->delete('categorias', array('id_categoria' => $id_categoria));
	// 		 return true;

	// 	} catch (Exception $e) {
	// 		echo $e->getMessage();
	// 		exit(1);
	// 	}
	// }

	// public function getCategoria($id_categoria)
	// {
	// 	try {

	// 		// Adicionales en ese automovil
	// 		$sql = "SELECT * FROM categorias C WHERE C.id_categoria=$id_categoria";
	// 		$q = $this->db->query($sql);
	// 		$categoria = $q->row_array();

	// 		return $categoria;

	// 	} catch (Exception $e) {
	// 		echo $e->getMessage();
	// 		exit(1);
	// 	}
	// }


}