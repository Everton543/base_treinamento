<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Produtos_Price_model extends CI_Model {

	public function store($produto){
		$this->db->insert('produto_create',$produto);
	}
	public function get_produtos(){
		$produtos = $this->db->get('produto_create')->result_array();
		return $produtos;
	}
	public function get_produtos_by_id($id){
		$produto = $this->db->where('id',$id)->get('produto_create')->row();
		return $produto;
	}
	public function update_produto($id,$produto){
		$this->db->where('id',$id)->update('produto_create',$produto);
	}
}
