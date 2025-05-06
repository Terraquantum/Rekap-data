<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */
	public function index()
	{
		$this->load->view('welcome_message');
	}


	public function create($id=false){
		$this->load->helper('form');
		$this->load->library('form_validation');

		$this->form_validation->set_rules('name', 'Name', 'required|max_length[30]');
		$this->form_validation->set_rules('description', 'Description', 'required');

		if($this->form_validation->run() == FALSE){
			$this->load->view('header');
			$this->load->view('create');
			$this->load->view('footer');
		} else {
			$id = uniqid('item', TRUE);

			$config['upload_path'] = './upload/post';
			$config['allowed_types'] = 'jpg|jpeg|png';
			$config['max_size'] = '100000';
			$config['file_ext_tolower'] = TRUE;
			$config['file_name'] = str_replace('.','_',$id);

			$this->load->library('upload', $config);

			if(! $this->upload->do_upload('image1')){
				$this->session->set_flashdata('error', $this->upload->display_errors());
				redirect('welcome/index');
			} else {
				$filename = $this->upload->data('file_name');
				$this->model->create($id, $filename);
				redirect('');
			}
		}
	}
















}



