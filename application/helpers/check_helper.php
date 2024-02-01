<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	/*******************************************************************************************************************
	 * Função para validar um endereço de e-mail.
	 * 
	 * Como funciona:
	 * - Recebe um endereço de e-mail como parâmetro.
	 * - Utiliza a função 'filter_var()' do PHP com o filtro 'FILTER_VALIDATE_EMAIL' para verificar se o endereço de e-mail 
	 * é válido.
	 * - Retorna 'true' se o endereço de e-mail for válido e 'false' caso contrário.
	 * 
	 * Parâmetros:
	 * - $email: O endereço de e-mail a ser validado.
	 * 
	 * Uso típico:
	 * - Esta função é chamada quando você precisa verificar se um endereço de e-mail fornecido é válido.
	 * - Ela retorna 'true' se o endereço de e-mail for válido de acordo com o formato padrão de e-mails, e 'false' caso 
	 * contrário.
	 *******************************************************************************************************************/
	function validarEmail($email){
	    if (filter_var($email, FILTER_VALIDATE_EMAIL)){
			return true;
		}
		return false;
	}
?>