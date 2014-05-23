<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Claves extends MY_Controller {



	public function __construct()
	{
		parent::__construct();
		$this->redirect_no_login();
		$this->load->model('categorias/categorias_model');
		$this->load->model('tags/tags_model');
		$this->load->model('claves/claves_model');
		//Carga de clases de Equipos
		//$this->load->library('categoria');
	}



	public function __destruct()
	{
		gc_collect_cycles();
	}



	public function index(){
		$this->listar();
	}




	public function agregar()
	{
		if(!$this->user->is_logged())       redirect('login');

		$data['url_action']     	= base_url('claves/agregar');
		$errores_validacion 	= array();

		if($this->input->server('REQUEST_METHOD') == 'POST')
		{
			$clave 				= $this->_getDataPost();
			$validate_clave    	= $this->claves_model->validate($clave);
			if ( empty($validate_clave) ) { // Validado OKA
					$insert_clave = $this->claves_model->insert($clave);
					if ($insert_clave > 0) {
							$this->session->set_flashdata('success','Los datos se han guardado con éxito.');
							redirect('claves/buscar');
					} else {
							$this->session->set_flashdata('error','Los datos no se pudieron guardar.');
							redirect('claves/buscar');
					}
			} else { // Falló la validación
					$errores_validacion = $validate_clave;
			}

		} else { // GET
			$clave = $this->_getDataPost();
		}


		$categorias 	= $this->categorias_model->getCategorias();
		$tags 			= $this->tags_model->getTags();


		$data['errores_validacion'] = $errores_validacion;
		$data['categorias']			= $categorias;
		$data['tags']				= $tags;
		$data['clave']  = $clave;
		$data['view_file'] = 'add_clave';

		$this->load->view('template',$data);



	}





	// public function listar($pagina = 'pagina', $page = 0)
	// {
	// 	if(!$this->user->is_logged())	redirect('login');



	// 	if ($this->session->flashdata("success")) {
	// 		$data['msg'] 		= $this->session->flashdata("success");
	// 	}
	// 	if ($this->session->flashdata("error")) {
	// 		$data['msg_error'] 	= $this->session->flashdata("error");
	// 	}

	// 	$data['form_action'] = base_url('categorias/listar');

	// 	$filter = array();

	// 	$categorias 		= $this->categorias_model->getCategorias();

	// 	$data['categorias'] 	= $categorias;
	// 	$data['view_file'] 		= 'listado_categorias';

	// 	$this->load->view('template',$data);
	// }

	public function buscar()
	{
		if(!$this->user->is_logged()) 	redirect('login');

		if ($this->session->flashdata("success")) {
			$data['msg'] 		= $this->session->flashdata("success");
		}
		if ($this->session->flashdata("error")) {
			$data['msg_error'] 	= $this->session->flashdata("error");
		}

		$data['form_action'] = base_url('claves/busqueda');
		$categorias 		= $this->categorias_model->getCategorias();
		$data['categorias'] 	= $categorias;
		$data['view_file'] 	= 'buscar_clave';

		$this->load->view('template',$data);

	}

	/**
	 * Ya esta realizando la búsqueda, debe mostrar los resultados.
	 **/
	public function busqueda()
	{
		if(!$this->user->is_logged()) 	redirect('login');

		if ($this->session->flashdata("success")) {
			$data['msg'] 		= $this->session->flashdata("success");
		}
		if ($this->session->flashdata("error")) {
			$data['msg_error'] 	= $this->session->flashdata("error");
		}


		if($this->input->server('REQUEST_METHOD') == 'POST')
		{
			$words_search['words'] 		= $this->input->post('palabras');
			$words_search['id_categoria']	= $this->input->post('id_categoria');
			$busqueda 	= $this->claves_model->simpleSearch($words_search);
		} else { // Viene por get
			redirect('claves/buscar');
		}

		$data['claves_encontradas'] = $busqueda;
		$data['form_action'] 	= base_url('claves/buscar');
		$categorias 			= $this->categorias_model->getCategorias();
		$data['categorias'] 		= $categorias;
		$data['view_file'] 		= 'claves_encontradas';

		$this->load->view('template',$data);

	}


	public function editar($id_categoria = 0)
	{
		if(!$this->user->is_logged())		redirect('login');
		if($id_categoria == 0)				show_404();

		$data['url_action'] 	= base_url('categorias/editar/' . $id_categoria);
		$errores_validacion = array();

		if($this->input->server('REQUEST_METHOD') == 'POST')
		{
			$categoria 			= $this->_getDataPost();
			$validate_categoria = $this->categorias_model->validateCategoria($categoria);

			if ( empty($validate_categoria) )
			{ 	// Validado OKA
				$update_categoria = $this->categorias_model->update($categoria, $id_categoria);
				if ($update_categoria) {
					$this->session->unset_userdata('nombre_foto_subida');
					$this->session->set_flashdata('success','Los datos se pudieron actualizar con éxito.');
					redirect('categorias/listar');
				} else {
					$this->session->set_flashdata('error','Los datos no se pudieron actualizar.');
					redirect('categorias/listar');
				}
			} else { // Falló la validación
				$errores_validacion = $validate_categoria;
			}

		} else { // GET
			$categoria = $this->_getDataGet($id_categoria);
		}


		$data['editar'] = false;
		$data['errores_validacion'] = $errores_validacion;

		$data['categoria'] 	= $categoria;
		$data['view_file'] 	= 'edit_categoria';

		$this->load->view('template',$data);
	}



	/**
	 * Va a eliminar un registro de una categoría (por AJAX)
	 *
	 * @team 	Allytech
	 * @author 	Juan Pablo Sosa <juans@allytech.com>
	 * @date 	12 de marzo del 2014
	 **/
	public function erase_ajax()
	{
		$id_categoria = $this->input->post('id_categoria');


		$erase_categoria = $this->categorias_model->eraseCategoria($id_categoria);

		if ($erase_categoria) {
			return true;
		} else {
			return false;
		}

	}



	/**
	 * Agarra por post los datos de la categoría
	 **/
	private function _getDataPost()
	{
		$clave = array();

		$clave['id_categoria']	= $this->input->post('id_categoria') ? $this->input->post('id_categoria') : 0;
		$clave['titulo']			= $this->input->post('titulo') ? $this->input->post('titulo') : '';
		$clave['url']				= $this->input->post('url') ? $this->input->post('url') : '';
		$clave['puerto']			= $this->input->post('puerto') ? $this->input->post('puerto') : '';
		$clave['email']			= $this->input->post('email') ? $this->input->post('email') : '';
		$clave['usuario']		= $this->input->post('usuario') ? $this->input->post('usuario') : '';
		$clave['clave']			= $this->input->post('clave') ? $this->input->post('clave') : '';
		$clave['descripcion']	= $this->input->post('descripcion') ? $this->input->post('descripcion') : '';
		// Tags
		if ($this->input->post('tags'))
		{
			foreach ($_POST['tags'] AS $k => $ad) {
				$clave['tags'][$k] = $ad;
			}
		} else {
			$clave['tags'] = array();
		}

		return $clave;

	}

	/**
	 * Agarra por get a la categoría
	 **/
	private function _getDataGet($id_categoria)
	{
		$categoria = $this->categorias_model->getCategoria($id_categoria);
		return $categoria;
	}

}

