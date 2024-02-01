<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class MY_Controller extends CI_Controller {
	public function __construct(){
		parent::__construct();
		if(!$this->session->userdata("usuario_logado")){
			redirect(base_url('login'));
		}
	}
}
