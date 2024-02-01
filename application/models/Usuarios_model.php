<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios_model extends CI_Model {
	
	/**********************************************************
	 * Esta função chamada "login_user" é usada para autenticar
	 * um usuário com base em seu email e senha no banco de dados.
	 * 
	 * - Primeiro, a função realiza uma consulta no banco de dados
	 *   para buscar um registro com o email fornecido.
	 * 
	 * - Se nenhum registro for encontrado com o email fornecido,
	 *   a função retorna "false" indicando que o login falhou.
	 * 
	 * - Se um registro for encontrado, a função verifica se a senha
	 *   fornecida corresponde à senha armazenada no banco de dados
	 *   usando "password_verify()". Se a senha corresponder, o login
	 *   é bem-sucedido.
	 * 
	 * - Se a senha não corresponder, a função atualiza o número de
	 *   tentativas de login falhas no registro do usuário e retorna
	 *   "false" indicando que o login falhou.
	 * 
	 * - Se o login for bem-sucedido, a função atualiza o campo
	 *   "ultimo_acesso" com a data e hora do último acesso do usuário
	 *   e retorna os dados do usuário autenticado com a chave "sucesso"
	 *   definida como "true".
	 * 
	 * - A função utiliza as funções do CodeIgniter para executar as
	 *   consultas SQL no banco de dados.
	 **********************************************************/
	public function login_user($email, $senha){
		$this->db->select('*');
		$this->db->from('usuario');
		$this->db->where('email', $email);
		$resultado = $this->db->get()->row_array();
		
		if($resultado == null){
			return false; // Email não encontrado, login falhou
		}

		if(count($resultado) == 0){
			return false; // Nenhum resultado encontrado, login falhou
		}

		// Verificar se a senha fornecida corresponde à senha no banco de dados
		if(password_verify($senha, $resultado['senha'])){
			date_default_timezone_set('America/Sao_Paulo');
			$timestamp = time();
			$resultado['sucesso'] = true;

			// Atualizar o campo "ultimo_acesso" com a data e hora do último acesso
			$this->db->set('ultimo_acesso', date("Y-m-d H:i:s", $timestamp));
			$this->db->where('id_usuario', $resultado['id_usuario']);
			$this->db->update('usuario');
		}else{
			$resultado['sucesso'] = false;

			// Atualizar o número de tentativas de login falhas
			$tentativas_falhas = $resultado['tentativas_falhas_login'];
			$tentativas_falhas++;
			$this->db->set('tentativas_falhas_login', $tentativas_falhas);
			$this->db->where('id_usuario', $resultado['id_usuario']);
			$this->db->update('usuario');
		}

		return $resultado; // Retornar os dados do usuário autenticado ou "false" em caso de falha de login
	}

	/**********************************************************
	 * Esta função chamada "pegarUsuarioPeloEmail" é usada para
	 * buscar um usuário no banco de dados com base no endereço
	 * de e-mail fornecido.
	 * 
	 * - A função realiza uma consulta no banco de dados para
	 *   buscar um registro na tabela "usuario" onde o campo
	 *   "email" corresponde ao endereço de e-mail fornecido.
	 * 
	 * - A consulta utiliza os métodos do CodeIgniter, como
	 *   "select", "from" e "where", para construir a consulta SQL.
	 * 
	 * - Se um registro for encontrado com o endereço de e-mail
	 *   fornecido, a função retorna os dados desse usuário como
	 *   um array associativo.
	 * 
	 * - Se nenhum registro for encontrado, a função retorna "null"
	 *   indicando que nenhum usuário com o e-mail especificado foi
	 *   encontrado.
	 * 
	 * - Essa função é útil para verificar se um usuário com um
	 *   determinado e-mail já está cadastrado no sistema antes de
	 *   tentar criar um novo registro com o mesmo e-mail.
	 **********************************************************/
	public function pegarUsuarioPeloEmail($email){
		$this->db->select('*');
		$this->db->from('usuario');
		$this->db->where('email', $email);
		
		// Realizar a consulta SQL no banco de dados e retornar o resultado como um array associativo
		// row_array sempre retorna apenas uma linha, caso queira fazer algo que retorne mais de uma linha
		// use result_array no lugar de row_array
		return $this->db->get()->row_array();
	}

	/**********************************************************************************************************
	 * Função para buscar um usuário no banco de dados com base em seu ID.
	 * 
	 * Como funciona:
	 * - Recebe o ID de usuário como parâmetro.
	 * - Configura a consulta SQL utilizando o CodeIgniter Query Builder.
	 * - Seleciona as colunas 'id_usuario', 'email', 'nome_usuario' e 'tipo_acesso' da tabela 'usuario'.
	 * - Adiciona uma cláusula WHERE para filtrar o usuário pelo seu ID.
	 * - Executa a consulta SQL no banco de dados e retorna o resultado como um único registro em formato de array 
	 * associativo.
	 * - Se nenhum usuário correspondente for encontrado, retorna um array vazio.
	 * 
	 * Parâmetros:
	 * - $id_usuario: O ID do usuário que será usado para buscar as informações no banco de dados.
	 * 
	 * Uso típico:
	 * - Esta função é chamada quando é necessário obter informações detalhadas de um usuário específico com base no seu ID.
	 * - Ela retorna um array associativo com os dados do usuário ou um array vazio se o usuário não for encontrado.
	 ***********************************************************************************************************/
	public function pegarUsuarioPeloId($id_usuario){
		$this->db->select('id_usuario, email, nome_usuario, tipo_acesso');
		$this->db->from('usuario');
		$this->db->where('id_usuario', $id_usuario);
		
		// Realizar a consulta SQL no banco de dados e retornar o resultado como um array associativo
		// row_array sempre retorna apenas uma linha, caso queira fazer algo que retorne mais de uma linha
		// use result_array no lugar de row_array
		return $this->db->get()->row_array();
	}

	/**********************************************************************************************************
	 * Função para editar os detalhes de um usuário no banco de dados com base nos dados fornecidos.
	 * 
	 * Como funciona:
	 * - Recebe um array associativo '$dados' contendo as informações a serem atualizadas para o usuário.
	 * - Utiliza o CodeIgniter Query Builder para construir uma consulta de atualização (UPDATE) no banco de dados.
	 * - Define as colunas a serem atualizadas, como 'nome_usuario', 'senha' e 'tipo_acesso', com base nos valores 
	 * fornecidos no array '$dados'.
	 * - Adiciona uma cláusula WHERE para identificar o usuário a ser atualizado com base no seu 'id_usuario'.
	 * - Executa a consulta de atualização no banco de dados.
	 * - Verifica se a atualização foi bem-sucedida verificando se houve afetação de linhas no banco de dados.
	 * - Retorna 'true' se a atualização foi bem-sucedida e 'false' caso contrário.
	 * 
	 * Parâmetros:
	 * - $dados: Um array associativo contendo as informações a serem atualizadas para o usuário, incluindo 'nome_usuario', 
	 * 'senha', 'tipo_acesso' e 'id_usuario'.
	 * 
	 * Uso típico:
	 * - Esta função é chamada quando o usuário deseja editar os detalhes de um usuário, como nome, senha e tipo de acesso.
	 * - Ela atualiza os dados no banco de dados e retorna 'true' se a operação foi bem-sucedida, ou 'false' se houve 
	 * algum erro.
	 ***********************************************************************************************************/
	public function editarUsuario($dados)
	{
		// Configura as colunas a serem atualizadas com base nos dados fornecidos
		$this->db->set('nome_usuario', $dados['nome_usuario']);
		if ($dados['senha'] != '') {
			$this->db->set('senha', $dados['senha']);
		}
		$this->db->set('tipo_acesso', $dados['tipo_acesso']);

		// Adiciona uma cláusula WHERE para identificar o usuário a ser atualizado com base no 'id_usuario'
		$this->db->where('id_usuario', $dados['id_usuario']);

		// Executa a consulta de atualização no banco de dados
		$this->db->update('usuario');

		// Verifica se a atualização foi bem-sucedida com base na afetação de linhas no banco de dados
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	/**********************************************************
	 * Esta função chamada "cadastrarUsuario" é responsável por
	 * inserir um novo registro de usuário no banco de dados.
	 * 
	 * - Ela recebe um array associativo "$usuario_dados" contendo
	 *   os dados do usuário que serão inseridos no banco de dados.
	 * 
	 * - A função utiliza o método "insert" do CodeIgniter para
	 *   realizar a inserção dos dados na tabela "usuario" do banco
	 *   de dados.
	 * 
	 * - Se a inserção for bem-sucedida, a função retorna "true",
	 *   indicando que o usuário foi cadastrado com sucesso.
	 * 
	 * - Se houver falha na inserção, a função retorna "false",
	 *   indicando que ocorreu algum erro durante o processo de
	 *   cadastro.
	 * 
	 * - O controle de erros e exceções relacionados à inserção
	 *   pode ser tratado no código que chama essa função.
	 **********************************************************/
	public function cadastrarUsuario($usuario_dados){
		// Tenta inserir os dados do usuário no banco de dados
		if ($this->db->insert('usuario', $usuario_dados)) {
			return true; // Retorna true se a inserção for bem-sucedida
		} else {
			return false; // Retorna false se houver falha na inserção
		}
	}

	/**********************************************************************************************************************
	 * Função para buscar uma lista de usuários no banco de dados com base em um tipo de acesso (opcional).
	 * 
	 * Como funciona:
	 * - Recebe o parâmetro '$tipo_acesso' que representa o tipo de acesso dos usuários a serem filtrados (opcional, 
	 * padrão é 'null').
	 * - Utiliza o CodeIgniter Query Builder para construir uma consulta SQL para buscar os usuários no banco de dados.
	 * - Seleciona as colunas 'id_usuario', 'email', 'nome_usuario' e 'tipo_acesso' da tabela 'usuario'.
	 * - Adiciona uma cláusula WHERE para filtrar os usuários pelo tipo de acesso, se o parâmetro '$tipo_acesso' for fornecido.
	 * - Define a ordem de classificação dos resultados, primeiro por 'tipo_acesso' em ordem ascendente e depois por 
	 * 'nome_usuario' em ordem ascendente.
	 * - Executa a consulta SQL no banco de dados e retorna o resultado como um array associativo de registros.
	 * 
	 * Parâmetros:
	 * - $tipo_acesso (opcional): O tipo de acesso usado para filtrar os usuários na consulta (padrão é 'null' para 
	 * buscar todos os usuários).
	 * 
	 * Uso típico:
	 * - Esta função é chamada quando é necessário buscar uma lista de usuários, possivelmente filtrada por tipo de acesso.
	 * - Ela retorna um array associativo com os dados dos usuários que correspondem aos critérios de busca.
	 *********************************************************************************************************************/
	public function pegarListaUsuarios($tipo_acesso = null){
		// Configura a seleção de colunas e a cláusula WHERE para buscar os usuários
		$this->db->select('id_usuario, email, nome_usuario, tipo_acesso');
		$this->db->from('usuario');

		// Adiciona uma cláusula WHERE para filtrar os usuários pelo tipo de acesso, se o parâmetro '$tipo_acesso' for fornecido
		if ($tipo_acesso != null) {
			$this->db->where('tipo_acesso', $tipo_acesso);
		}

		// Define a ordem de classificação dos resultados
		$this->db->order_by('tipo_acesso', 'ASC');
		$this->db->order_by('nome_usuario', 'ASC');

		// Executa a consulta SQL no banco de dados e retorna o resultado como um array associativo de registros
		return $this->db->get()->result_array();
	}

	/**********************************************************************************************************************
	 * Função para deletar um usuário do banco de dados com base no ID do usuário.
	 * 
	 * Como funciona:
	 * - Recebe o ID de usuário como parâmetro.
	 * - Utiliza o CodeIgniter Query Builder para construir uma consulta de exclusão (DELETE) no banco de dados.
	 * - Adiciona uma cláusula WHERE para identificar o usuário a ser excluído com base no seu 'id_usuario'.
	 * - Executa a consulta de exclusão no banco de dados.
	 * - Verifica se a exclusão foi bem-sucedida verificando se houve afetação de linhas no banco de dados.
	 * - Retorna 'true' se a exclusão foi bem-sucedida e 'false' caso contrário.
	 * 
	 * Parâmetros:
	 * - $id_usuario: O ID do usuário que será excluído do banco de dados.
	 * 
	 * Uso típico:
	 * - Esta função é chamada quando o usuário deseja excluir um usuário específico com base no ID do usuário.
	 * - Ela executa a exclusão no banco de dados e retorna 'true' se a operação foi bem-sucedida, ou 'false' se houve 
	 * algum erro.
	 ***********************************************************************************************************************/
	public function deletarUsuario($id_usuario)
	{
		// Adiciona uma cláusula WHERE para identificar o usuário a ser excluído com base no 'id_usuario'
		$this->db->where('id_usuario', $id_usuario);

		// Executa a consulta de exclusão no banco de dados
		$this->db->delete('usuario');

		// Verifica se a exclusão foi bem-sucedida com base na afetação de linhas no banco de dados
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
}