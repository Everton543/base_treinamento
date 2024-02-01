<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*****************************************************************
 * Autor: Everton Alves
 *****************************************************************/
class Template{
    /************************************************************************************************************************************
     * Construtor da classe.
     * 
     * Como funciona:
     * - Este construtor é usado para inicializar a classe e carregar uma instância do CodeIgniter (CI).
     * - Ele utiliza a função 'get_instance()' para obter uma referência à instância do CodeIgniter (CI) atualmente em execução.
     * - A referência ao CI é armazenada em uma propriedade da classe, permitindo que a classe acesse recursos e funcionalidades do 
     * CodeIgniter.
     * 
     * Uso típico:
     * - Este construtor é executado automaticamente quando um objeto da classe é criado.
     * - Ele é usado para configurar e preparar a classe para interagir com o CodeIgniter, fornecendo acesso aos recursos do 
     * framework.
     *************************************************************************************************************************************/
    public function __construct()
	{
		//Carrega instancia do CI
		$this->CI =& get_instance();
	}

    /******************************************************************************************
     * Nesta função chamada "load", estamos lidando com a carga dinâmica de conteúdo em um template
     * no CodeIgniter, facilitando a construção de páginas web dinâmicas.
     * 
     * - O primeiro parâmetro, "$caminho", especifica o caminho para o arquivo de conteúdo que será
     *   carregado dentro do template.
     * 
     * - O segundo parâmetro, "$conteudo", é um array associativo que pode conter dados extras que
     *   serão passados para a view carregada.
     * 
     * - O terceiro parâmetro, "$retornarHtml", é opcional e determina se a função deve retornar
     *   o conteúdo HTML gerado ou carregá-lo diretamente no navegador. O padrão é não retornar HTML.
     * 
     * - A função começa carregando o conteúdo da view especificada pelo caminho usando
     *   "$this->CI->load->view()". O terceiro parâmetro "true" indica que o conteúdo deve ser
     *   retornado como uma string em vez de ser exibido no navegador.
     * 
     * - Em seguida, obtém informações da sessão, como o tipo de acesso do usuário, o nome do
     *   usuário e a URL inicial com base no tipo de acesso.
     * 
     * - Em seguida, cria um array "$dados" que contém o conteúdo carregado, o título da página,
     *   o tipo de acesso, o nome do usuário e a URL inicial.
     * 
     * - Finalmente, dependendo do valor de "$retornarHtml", a função pode retornar o conteúdo HTML
     *   gerado ou carregá-lo diretamente no navegador usando "$this->CI->load->view()".
     ******************************************************************************************/
    public function load($caminho, $conteudo = [], $retornarHtml = false){
        $htmlConteudo = $this->CI->load->view($caminho, $conteudo, true);
        $tipo_acesso = $this->CI->session->userdata('tipo_acesso');
        $nome_usuario = $this->CI->session->userdata('nome_usuario');
        $homeUrl = base_url();
        switch ($tipo_acesso){
            case '1':
                $homeUrl = base_url('cliente');
                break;
            case '2':
                $homeUrl = base_url('loja');
                break;
        }

        $dados = [
            'conteudo' => $htmlConteudo,
            'title' => $conteudo['title'] ?? null,
            'tipo_acesso' => $tipo_acesso,
            'nome_usuario' => $nome_usuario,
            'homeUrl' => $homeUrl
        ];

        return $this->CI->load->view('template/index', $dados, $retornarHtml);
    }

    /**********************************************************************
     * Esta função chamada "listaTipoAcesso" é responsável por retornar uma
     * lista de tipos de acesso disponíveis em um sistema. Os tipos de acesso
     * geralmente representam diferentes papéis ou níveis de permissão de
     * usuários no sistema.
     * 
     * - A função retorna um array de arrays associativos, onde cada elemento
     *   contém as informações de um tipo de acesso. Cada elemento tem duas
     *   chaves: "id" e "tipo".
     * 
     * - "id" representa um identificador único para o tipo de acesso.
     * 
     * - "tipo" representa a descrição do tipo de acesso, geralmente em formato
     *   legível por humanos, como "Cliente" ou "Loja".
     * 
     * - Neste exemplo, a função retorna dois tipos de acesso: "Cliente" e "Loja",
     *   com IDs 1 e 2, respectivamente. Esses tipos de acesso podem ser usados
     *   para determinar as permissões e funcionalidades disponíveis para diferentes
     *   categorias de usuários no sistema.
     **********************************************************************/
    public function listaTipoAcesso(){
        return [
            [
                "id" => 1,
                "tipo" => "Cliente"
            ],
            [
                "id" => 2,
                "tipo" => "Loja"
            ]
        ];
    }
}
?>