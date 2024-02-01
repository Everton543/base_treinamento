<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cliente extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->library('template'); //Carrega a biblioteca de template
    }

    public function index(){
        $dados = [
			'title' => 'Cliente'
		];
		$this->template->load('clientePaginaPrincipal', $dados);
    }
}