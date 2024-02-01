<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	/**********************************************************************************************************
	 * Construtor da classe.
	 * 
	 * Como funciona:
	 * - Chama o construtor da classe pai (parent::__construct()) para garantir que as inicializações da classe pai 
	 * sejam executadas.
	 * - Carrega o helper 'check', que contém funções auxiliares para verificar determinadas condições.
	 * - Carrega a biblioteca 'template', que pode ser usada para lidar com a renderização de templates e views.
	 * - Carrega o modelo 'usuarios_model', que é responsável por interagir com os dados dos usuários no banco de dados.
	 * 
	 * Uso típico:
	 * - Este construtor é executado automaticamente quando um objeto da classe é criado.
	 * - Ele é usado para configurar e carregar recursos necessários, como helpers, bibliotecas e modelos, que serão 
	 * usados em outras partes da classe.
	 * - Isso ajuda a manter o código organizado e facilita o uso de funcionalidades específicas ao longo da classe.
	 *********************************************************************************************************/
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('check');
		$this->load->library('template'); //Carrega a biblioteca de template
		$this->load->model('usuarios_model');
	}

	/********************************************************************************************************
	 * Nesta função chamada "index", estamos lidando com a exibição da página de login em um sistema web.
	 * 
	 * - Primeiro, definimos alguns dados que serão utilizados na página, como o título da página e a lista de tipos de acesso.
	 * 
	 * - O título da página é definido como "Login" para ser exibido na barra de título do navegador.
	 * 
	 * - A lista de tipos de acesso é obtida por meio da função "listaTipoAcesso()" do objeto "template". Esses dados podem ser 
	 * usados para criar opções de login com diferentes níveis de acesso.
	 * 
	 * - Em seguida, utilizamos o template "login" para carregar a página de login, passando os dados definidos anteriormente. 
	 * O template é responsável por renderizar a página e combinar os dados com a estrutura HTML.
	 * 
	 * - Quando um usuário acessa a URL correspondente a esta função, ele é direcionado para a página de login, onde pode 
	 * inserir suas credenciais para acessar o sistema.
	 ********************************************************************************************************/
	public function index(){
		$dados = [
			'title' => 'Login',
			'acessos' => $this->template->listaTipoAcesso()
		];
		$this->template->load('login', $dados);
	}

	/********************************************************************************************************
	 *	A sessão de usuário é um mecanismo de armazenamento temporário de dados associados a um usuário
	 * durante sua interação com um aplicativo ou site. Esses dados podem incluir informações de login,
	 * preferências do usuário, itens em um carrinho de compras, ou qualquer outro tipo de estado que
	 * precise ser mantido enquanto o usuário navega no aplicativo. As sessões geralmente são usadas
	 * para proporcionar uma experiência personalizada e contínua ao usuário em diferentes páginas ou visitas
	 * ao aplicativo, sem a necessidade de autenticação constante.
	 *********************************************************************************************************/
	public function ajax_autenticar(){
		$email = $this->input->post('email');
		$senha = $this->input->post('senha');
		//transforma o texto do email para minusculo para evitar criar emails iguais
		$email = strtolower($email);

		$resultado['sucesso'] = false;
		if(validarEmail($email)){
			$usuario = $this->usuarios_model->login_user($email, $senha);
			if($usuario){
				$resultado['sucesso'] = true;
				// $resultado['dados'] = $usuario;
				if($usuario){
					//set_userdata serve para armazenar dados na sessão de um usuário no CodeIgniter.
					$this->session->set_userdata('id_usuario',$usuario['id_usuario']);
					$this->session->set_userdata('nome_usuario',$usuario['nome_usuario']);
					$this->session->set_userdata('tipo_acesso',$usuario['tipo_acesso']);
					switch($usuario['tipo_acesso']){
						case '1'://tipo Cliente
							$resultado['destino'] = base_url('cliente');
							break;
						case '2': //tipo Loja
							$resultado['destino'] = base_url('loja');
							break;
					}
				}
			}
		}
		echo json_encode($resultado);
	}

	/*********************************************************************************************************
	 * Nesta função chamada "ajax_cadastrar", estamos lidando com o processo de cadastramento de um usuário em um sistema web.
	 * 
	 * 1. Primeiro, pegamos os dados do formulário que foram enviados por meio de uma requisição AJAX.
	 * 
	 * 2. Em seguida, transformamos o texto do email para letras minúsculas, o que ajuda a evitar a criação de múltiplos 
	 * cadastros com emails iguais.
	 * 
	 * 3. Verificamos se já existe um usuário com o mesmo email no banco de dados. Se não houver, continuamos o processo.
	 * 
	 * 4. Caso o email seja único, criptografamos a senha do usuário para garantir sua segurança usando a função password_hash().
	 * 
	 * 5. Em seguida, tentamos cadastrar o novo usuário no sistema usando a função "cadastrarUsuario" do modelo "usuarios_model".
	 * 
	 * 6. Se o cadastro for bem-sucedido, definimos "sucesso" como verdadeiro e retornamos uma mensagem de sucesso.
	 * 
	 * 7. Se já existir um usuário com o mesmo email, definimos "mensagem" como "Email já cadastrado" para informar ao usuário 
	 * que ele precisa escolher um email diferente.
	 * 
	 * 8. Finalmente, enviamos os resultados de volta para a requisição AJAX em formato JSON, para que o frontend possa 
	 * processar as informações e tomar as medidas apropriadas.
	 *********************************************************************************************************/
	public function ajax_cadastrar(){
		$dados = $this->input->post();
		//transforma o texto do email para minusculo para evitar criar emails iguais
		$dados['email'] = strtolower($dados['email']);
		$existeUsuario = $this->usuarios_model->pegarUsuarioPeloEmail($dados['email']);
		$resultado['sucesso'] = false;
		$resultado['mensagem'] = "";
		if($existeUsuario == null){
			$dados['senha'] = password_hash($dados['senha'], PASSWORD_DEFAULT);
			$resultado['sucesso'] = $this->usuarios_model->cadastrarUsuario($dados);
		}else{
			$resultado['mensagem'] = "Email já cadastrado";
		}
		echo json_encode($resultado);
	}

	/*********************************************************************************************************
	 * Esta função é responsável por efetuar o logout de um usuário em um aplicativo CodeIgniter.
	 * Primeiro, ela utiliza a função unset_userdata() para remover os dados armazenados na sessão
	 * do usuário, incluindo 'id_usuario', 'tipo_acesso' e 'nome_usuario'.
	 * Em seguida, a função session_destroy() é usada para destruir completamente a sessão do usuário.
	 * Finalmente, a função redirect() redireciona o usuário de volta para a página inicial do aplicativo.
	 *********************************************************************************************************/
	public function logout(){
		//unset_userdata serve para deletar dados armazenados na sessão de um usuário no CodeIgniter.
		$this->session->unset_userdata('id_usuario');
		$this->session->unset_userdata('tipo_acesso');
		$this->session->unset_userdata('nome_usuario');
		session_destroy();
		redirect(base_url());
	}

	/***********************************************************************************************************
	 * Função AJAX que lista os usuários com base no tipo de acesso fornecido.
	 * 
	 * Como funciona:
	 * - Recebe o tipo de acesso como um parâmetro GET da solicitação AJAX (ou usa 'null' se não for fornecido).
	 * - Chama o método 'pegarListaUsuarios()' do modelo 'usuarios_model' para obter a lista de usuários com o tipo de 
	 * acesso especificado.
	 * - Converte a lista de usuários em formato PHP para JSON usando 'json_encode()'.
	 * - Imprime o JSON resultante como resposta à solicitação AJAX.
	 * 
	 * Parâmetros:
	 * - Nenhum parâmetro é passado diretamente para esta função, mas ela depende do parâmetro GET 'tipo_acesso' da 
	 * solicitação AJAX.
	 * 
	 * Uso típico:
	 * - Esta função é chamada via solicitação AJAX quando o cliente deseja obter uma lista de usuários com base em um 
	 * filtro de tipo de acesso.
	 * - Ela consulta o modelo 'usuarios_model' para obter os dados, converte-os em formato JSON e envia a resposta de 
	 * volta ao cliente.
	 ************************************************************************************************************/
	public function ajax_listarUsuarios(){
		// Obtém o tipo de acesso a partir da solicitação AJAX ou define como 'null' se não for fornecido
		$tipo_acesso = $this->input->get('tipo_acesso') ?? null;

		// Chama o método no modelo 'usuarios_model' para obter a lista de usuários com o tipo de acesso especificado
		$listaUsuario = $this->usuarios_model->pegarListaUsuarios($tipo_acesso);

		// Converte a lista de usuários em formato PHP para JSON e a imprime como resposta à solicitação AJAX
		echo json_encode($listaUsuario);
	}


	/***********************************************************************************************************
	 * Função AJAX para deletar um usuário com base no ID de usuário fornecido.
	 * 
	 * Como funciona:
	 * - Recebe o ID de usuário como um parâmetro POST da solicitação AJAX (ou define como 'null' se não for fornecido).
	 * - Chama o método 'deletarUsuario()' do modelo 'usuarios_model' para tentar excluir o usuário com o ID fornecido.
	 * - Armazena o resultado da operação de exclusão (true se bem-sucedido, false caso contrário) em um array associativo 
	 * 'resultado'.
	 * - Converte esse array em formato JSON usando 'json_encode()'.
	 * - Imprime o JSON resultante como resposta à solicitação AJAX, informando se a exclusão foi bem-sucedida ou não.
	 * 
	 * Parâmetros:
	 * - Nenhum parâmetro é passado diretamente para esta função, mas ela depende do parâmetro POST 'id_usuario' da solicitação 
	 * AJAX.
	 * 
	 * Uso típico:
	 * - Esta função é chamada via solicitação AJAX quando o cliente deseja excluir um usuário específico com base no ID do 
	 * usuário.
	 * - Ela chama o modelo 'usuarios_model' para executar a operação de exclusão, informa o resultado e envia a resposta ao 
	 * cliente.
	 ************************************************************************************************************/
	public function ajax_deletar(){
		// Obtém o ID de usuário a partir da solicitação AJAX ou define como 'null' se não for fornecido
		$id_usuario = $this->input->post('id_usuario') ?? null;

		// Chama o método no modelo 'usuarios_model' para tentar excluir o usuário com o ID fornecido
		$resultado['sucesso'] = $this->usuarios_model->deletarUsuario($id_usuario);

		// Converte o resultado da operação em formato PHP para JSON e o imprime como resposta à solicitação AJAX
		echo json_encode($resultado);
	}


	/***********************************************************************************************************
	 * Função para carregar a página de edição de um usuário com base no ID do usuário.
	 * 
	 * Como funciona:
	 * - Recebe o ID de usuário como parâmetro da URL.
	 * - Cria um array associativo 'dados' que contém informações como o título da página ('title') e uma lista de tipos de 
	 * acesso.
	 * - Chama o método 'listaTipoAcesso()' da biblioteca 'template' para obter a lista de tipos de acesso.
	 * - Chama o método 'pegarUsuarioPeloId()' do modelo 'usuarios_model' para obter os dados do usuário com o ID fornecido.
	 * - Adiciona esses dados ao array 'dados'.
	 * - Carrega a página 'editarUsuario' do template 'template' com os dados fornecidos.
	 * 
	 * Parâmetros:
	 * - $id_usuario: O ID do usuário que será editado, passado como parâmetro na URL.
	 * 
	 * Uso típico:
	 * - Esta função é chamada quando o usuário deseja editar os detalhes de um usuário específico.
	 * - Ela obtém os dados do usuário com base no ID fornecido, carrega informações adicionais como tipos de acesso e 
	 * carrega a página de edição.
	 ************************************************************************************************************/
	public function editarUsuario($id_usuario){
		// Cria um array associativo 'dados' com informações básicas
		$dados = [
			'title' => 'Editar',
			'acessos' => $this->template->listaTipoAcesso()
		];

		// Obtém os dados do usuário com base no ID fornecido
		$dados['usuario'] = $this->usuarios_model->pegarUsuarioPeloId($id_usuario);

		// Carrega a página 'editarUsuario' do template 'template' com os dados fornecidos
		$this->template->load('editarUsuario', $dados);
	}

	/************************************************************************************************************
	 * Função AJAX para editar os detalhes de um usuário com base nos dados fornecidos.
	 * 
	 * Como funciona:
	 * - Recebe os dados de edição do usuário via método POST da solicitação AJAX.
	 * - Inicializa um array associativo 'resultado' com valores padrão, incluindo 'sucesso' como falso e uma mensagem vazia.
	 * - Verifica se uma senha foi fornecida no conjunto de dados. Se sim, a senha é hasheada com o algoritmo de hash padrão.
	 * - Chama o método 'editarUsuario()' do modelo 'usuarios_model' para tentar editar os detalhes do usuário com os dados 
	 * fornecidos.
	 * - Atualiza o campo 'sucesso' em 'resultado' com o resultado da operação de edição (true se bem-sucedida, false caso 
	 * contrário).
	 * - Imprime o array 'resultado' como resposta à solicitação AJAX, incluindo informações sobre o sucesso da operação e, 
	 * opcionalmente, uma mensagem.
	 * 
	 * Parâmetros:
	 * - Os dados de edição do usuário são passados via método POST na solicitação AJAX.
	 * 
	 * Uso típico:
	 * - Esta função é chamada via solicitação AJAX quando o cliente deseja editar os detalhes de um usuário.
	 * - Ela verifica se uma senha foi fornecida, atualiza os dados do usuário, informa o resultado da operação e envia a 
	 * resposta ao cliente.
	 *************************************************************************************************************/
	public function ajax_editarUsuario(){
		// Recebe os dados de edição do usuário via método POST da solicitação AJAX
		$dados = $this->input->post();
		$resultado['sucesso'] = false;
		$dados['senha'] = $dados['senha'] ?? '';

		// Verifica se uma senha foi fornecida no conjunto de dados. Se sim, a senha é hasheada com o algoritmo de hash padrão
		if($dados['senha'] != ''){
			$dados['senha'] = password_hash($dados['senha'], PASSWORD_DEFAULT);
		}

		// Chama o método no modelo 'usuarios_model' para tentar editar os detalhes do usuário com os dados fornecidos
		$resultado['sucesso'] = $this->usuarios_model->editarUsuario($dados);

		// Imprime o array 'resultado' como resposta à solicitação AJAX, incluindo informações sobre o sucesso da operação e, opcionalmente, uma mensagem
		echo json_encode($resultado);
	}
}
