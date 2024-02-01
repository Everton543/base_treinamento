<style>
    .login-panel {
        width: 100%;
        max-width: 500px;
        padding: 15px;
        margin: 0 auto;
        margin-top: 60px;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .glyphicon-refresh {
        animation: spin 1s linear infinite;
    }
</style>
<div class="container">
    <div class="login-panel panel panel-default">
        <div class="panel-heading">
            <h1 class="panel-title text-center">Login</h1>
        </div>
        <div class="panel-body">
            <div id="alerta"></div>
            <div id="loginForm">
                <div class="form-group">
                    <label for="email"><span class="glyphicon glyphicon-flag"></span> E-mail</label>
                    <input class="form-control" placeholder="E-mail" id="email" type="email" maxlength="255" required autofocus>
                </div>
                <div class="form-group">
                    <label for="senha"><span class="glyphicon glyphicon-flag"></span> Senha</label>
                    <input class="form-control" placeholder="Senha" id="senha" type="password"  maxlength="255" required>
                    <span id="olho_senha_login" class="glyphicon glyphicon-eye-open" onclick="mostrarSenha('senha', 'olho_senha_login')" style="position: relative; top: -25px; left: 94%; cursor: pointer;"></span>
                </div>
                <button type="submit" class="btn btn-lg btn-success btn-block" onclick="login()">Entrar</button>

                <!-- O atributo data-target e data-toggle é usado para associar elementos a um componente modal em Bootstrap, controlando sua exibição e comportamento. -->
                <a data-toggle="modal" data-target="#modalCadastro" style="padding-bottom: 17px; display: block;">Não tem uma conta? Cadastre-se</a>
                <button class="btn btn-lg btn-primary btn-block" onclick="abrirModalListarUsuarios()">Mostar Contas Cadastradas</button>
            </div>
        </div>
    </div>
</div>
<!-- O valor do id serve para funcionar com o data-target da tag <a> anterior-->
<div class="modal fade" id="modalCadastro" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Cadastrar Usuário</h4>
            </div>
            <div class="modal-body">
                <div id="alerta_modal"></div>
                <div class="form-group">
                    <label for="email_cadastro"><span class="glyphicon glyphicon-flag"></span> E-mail</label>
                    <input class="form-control" placeholder="E-mail" id="email_cadastro" type="email" maxlength="255" required autofocus>
                </div>
                <div class="form-group">
                    <label for="senha_cadastro"><span class="glyphicon glyphicon-flag"></span> Senha</label>
                    <input class="form-control" placeholder="Senha" id="senha_cadastro" type="password"  maxlength="255" required>
                    <span id="olho_senha" class="glyphicon glyphicon-eye-open" onclick="mostrarSenha('senha_cadastro', 'olho_senha')" style="position: relative; top: -25px; left: 94%; cursor: pointer;"></span>
                </div>
                <div class="form-group">
                    <label for="nome_usuario"><span class="glyphicon glyphicon-flag"></span> Nome</label>
                    <input class="form-control" placeholder="Nome" id="nome_usuario" type="text"  maxlength="255" required>
                </div>
                <div class="form-group">
                    <label for="tipo_acesso"><span class="glyphicon glyphicon-flag"></span> Tipo Acesso</label>
                    <select class="form-control" id="tipo_acesso" required>
                        <?php foreach($acessos as $acesso) : ?>
                            <option value="<?=$acesso['id']?>"><?=$acesso['tipo']?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="cadastrarUsuario()">Cadastrar</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="modalContas" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content col-lg-12 col-md-12 col-sm-12">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Lista Usuários</h4>
            </div>
            <div class="modal-body">
                <div id="alerta_modal_lista"></div>
            <div class="row">
                <div class="form-group">
                    <div class="col-lg-9 col-md-9 col-sm-12">
                        <div class="input-group">
                            <span class="input-group-addon">Tipo Acesso:</span>
                            <select allow_blank="true" class="form-control" id="tipo_acesso_filtro" multipart="true">
                                <option value="">Todos</option>
                                <?php foreach($acessos as $acesso) : ?>
                                    <option value="<?=$acesso['id']?>"><?=$acesso['tipo']?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-12">
                        <div class="input-group">
                            <button type="button" class="btn btn-default" onclick="listarUsuarios()"><i class="glyphicon glyphicon-search"></i> Buscar</button>
                        </div>
                    </div>
                </div>
                <div id="alerta_modal_constas"></div>
                <table class="table table-hover table-striped">
                    <thead>
                        <th>Email</th>
                        <th>Nome Usuario</th>
                        <th>Tipo Usuario</th>
                        <th>Opções</th>
                    </thead>
                    <tbody id="lista_contas">
                        <tr>
                            <td colspan="3">
                                <i class="glyphicon glyphicon-refresh"></i>Carregando dados...
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="cadastrarUsuario()">Cadastrar</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script>
    /*******************************************************************************************
     * Esta função é usada para validar os dados de entrada do usuário em um formulário.
     * Verifica se o email é válido usando a função validarEmail() e se a senha não está vazia.
     * Em caso de erro, exibe um aviso e retorna false. Caso contrário, retorna true indicando
     * que os dados são válidos.
     ********************************************************************************************/
    function validarDados(email, senha){
        if(!validarEmail(email)){
            exibirAviso('Email invalido', 'alerta');
            return false;
        }
        //pega o valor do input senha caso seja NULL ou '' irá pegar o valor do outro lado do ??
        senha = senha ?? false; 
        if(!senha){
            exibirAviso('Senha vazia', 'alerta');
            return false;
        }
        return true;
    }

    /*********************************************************
     * Esta função chamada "validarDadosCadastro" é responsável
     * por validar os dados de cadastro de um novo usuário antes
     * de enviá-los para o servidor.
     * 
     * - Ela recebe três parâmetros: "email", "senha" e "nome_usuario".
     *   Esses parâmetros representam os dados de cadastro fornecidos
     *   pelo usuário.
     * 
     * - A função começa validando o email chamando a função "validarEmail"
     *   que verifica se o email fornecido é válido. Se o email não for
     *   válido, a função exibe uma mensagem de erro e retorna "false",
     *   indicando que os dados não são válidos.
     * 
     * - Em seguida, a função verifica se a senha é vazia ou nula usando
     *   a expressão "senha = senha ?? false". Se a senha for vazia ou
     *   nula, a função exibe uma mensagem de erro e retorna "false".
     * 
     * - Da mesma forma, a função verifica se o nome do usuário é vazio
     *   ou nulo usando a expressão "nome_usuario = nome_usuario ?? false".
     *   Se o nome do usuário for vazio ou nulo, a função exibe uma mensagem
     *   de erro e retorna "false".
     * 
     * - Se todos os dados forem válidos, a função retorna "true",
     *   indicando que os dados de cadastro são válidos e podem ser
     *   enviados para o servidor.
     * 
     * - Essa função é útil para garantir que os dados fornecidos pelo
     *   usuário atendam aos critérios de validação antes de prosseguir
     *   com o cadastro.
     *********************************************************/
    function validarDadosCadastro(email, senha, nome_usuario){
        if(!validarEmail(email)){
            exibirAviso('Email inválido', 'alerta_modal');
            return false;
        }
        
        // Verificar se a senha é vazia ou nula
        senha = senha ?? false; 
        if(!senha){
            exibirAviso('Senha vazia', 'alerta_modal');
            return false;
        }
        
        // Verificar se o nome do usuário é vazio ou nulo
        nome_usuario = nome_usuario ?? false; 
        if(!nome_usuario){
            exibirAviso('Nome vazio', 'alerta_modal');
            return false;
        }

        return true; // Dados de cadastro válidos
    }


    /*******************************************************************************************
     * Esta função é usada para validar um endereço de email.
     * Ela pega o valor do campo de email e verifica se está vazio.
     * Em seguida, aplica uma expressão regular para verificar se o email é válido.
     * Retorna true se o email for válido, caso contrário, retorna false.
     *******************************************************************************************/
    function validarEmail(email){
        email = email ?? false;
        if(!email){
            return false;
        }
        
        let regexEmail = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
        return regexEmail.test(email);
    }

    /*******************************************************************************************
     * Esta função é responsável por realizar uma tentativa de login do usuário.
     * Antes de enviar a requisição AJAX, ela chama a função validarDados() para garantir
     * que os campos de email e senha sejam preenchidos corretamente.
     * Em caso de sucesso, redireciona o usuário para a página de destino indicada nos dados de resposta.
     * Se houver falha, exibe uma mensagem de aviso e limpa o campo de senha.
     *******************************************************************************************/
    function login(){
        let email = $("#email").val();
        let senha = $("#senha").val(); 
        if(!validarDados(email, senha)){
            $("#senha").val('');
            return;
        }
        $.ajax({
            url: "<?=base_url('login/ajax_autenticar')?>", // URL que será chamada a requesição
            type: "POST", // Tipo de requisição (GET, POST, etc.)
            dataType: "json", // Tipo de dados esperado na resposta, como está no estilo json ele só irá aceitar valores JSON como resultado, se o retorno não for um JSON irá para a função error
            data: { //dados que serão enviados pela requesição
                email: email,
                senha: senha
            },
            cache: false,
            success: function(data) { //caso a requesição deu certo ela entrará neste espaço
                if(data.sucesso){
                    window.location.href = data.destino;
                }else{
                    exibirAviso('Email ou senha está incorreto', 'alerta');
                    $("#senha").val('');
                }
            },
            error: function() { //caso dê erro na requesição(por exemplo url que não existe) entrará neste espaço
                exibirAviso('Aconteceu um erro em nosso servidor', 'alerta');
            }
        });
    }

    /*********************************************************
     * Esta função chamada "cadastrarUsuario" é responsável por
     * enviar os dados de cadastro de um novo usuário para o
     * servidor por meio de uma requisição AJAX.
     * 
     * - Primeiro, a função obtém os valores dos campos de email,
     *   senha, nome de usuário e tipo de acesso a partir dos
     *   elementos HTML correspondentes usando jQuery.
     * 
     * - Em seguida, ela verifica se os dados de cadastro são
     * válidos, chamando a função "validarDadosCadastro". Se os
     * dados não forem válidos, a função limpa o campo de senha
     * e retorna sem fazer a requisição AJAX.
     * 
     * - Se os dados forem válidos, a função utiliza o método
     *   $.ajax() do jQuery para enviar uma requisição POST para
     *   a URL especificada em "url".
     * 
     * - Os dados do usuário, como email, senha, nome de usuário
     *   e tipo de acesso, são enviados como parte da requisição
     *   no formato JSON.
     * 
     * - A função especifica o tipo de dados esperado na resposta
     *   como JSON ("dataType: 'json'") e define a função "success"
     *   para lidar com a resposta bem-sucedida da requisição.
     * 
     * - Se a requisição for bem-sucedida, a função verifica se
     *   a resposta indica sucesso ("data.sucesso") e, em caso
     *   positivo, limpa os campos de entrada, fecha o modal de
     *   cadastro e exibe uma mensagem de sucesso.
     * 
     * - Se a requisição não for bem-sucedida, a função exibe
     *   uma mensagem de erro genérica.
     * 
     * - Em caso de erro na requisição, a função "error" é chamada
     *   para lidar com possíveis problemas na comunicação com o
     *   servidor.
     *********************************************************/
    function cadastrarUsuario(){
        let email = $("#email_cadastro").val();
        let senha = $("#senha_cadastro").val();
        let nome_usuario = $("#nome_usuario").val();
        let tipo_acesso = $("#tipo_acesso").val();
        
        // Verificar se os dados de cadastro são válidos
        if(!validarDadosCadastro(email, senha, nome_usuario)){
            // Limpar o campo de senha em caso de dados inválidos
            $("#senha_cadastro").val('');
            return;
        }
        
        $.ajax({
            url: "<?=base_url('login/ajax_cadastrar')?>",
            type: "POST",
            dataType: "json",
            data: {
                email: email,
                senha: senha,
                nome_usuario: nome_usuario,
                tipo_acesso: tipo_acesso
            },
            cache: false,
            success: function(data) {
                if(data.sucesso){
                    //Coloca no login os valores do novo cadastro
                    $("#email").val(email);
                    $("#senha").val(senha);

                    // Limpar os campos de entrada
                    $("#senha_cadastro").val('');
                    $("#email_cadastro").val('');
                    $("#nome_usuario").val('');
                    
                    // Fechar o modal de cadastro
                    $("#modalCadastro").modal("hide");
                    
                    // Exibir mensagem de sucesso
                    exibirAviso('Usuário cadastrado com sucesso', 'alerta', 'SUCESSO');
                }else{
                    let mensagem = data.mensagem ?? 'Aconteceu um erro em nosso servidor';
                    exibirAviso(mensagem, 'alerta_modal');
                    $("#senha").val('');
                }
            },
            error: function() {
                exibirAviso('Aconteceu um erro em nosso servidor', 'alerta_modal');
            }
        });
    }

    /***************************************************************************************
     * Esta função é responsável por editar as informações de um usuário no sistema.
     * 
     * Como funciona:
     * - Obtém os valores dos campos de senha, nome de usuário e tipo de acesso do formulário.
     * - Verifica se os dados de cadastro são válidos chamando a função validarDadosEditar().
     * - Se os dados não forem válidos, limpa o campo de senha e encerra a função.
     * - Caso contrário, envia uma solicitação AJAX para o servidor, com os dados do usuário a serem editados.
     * - Trata a resposta do servidor: se a edição for bem-sucedida, exibe uma mensagem de sucesso.
     * - Se nada for alterado no usuário, exibe uma mensagem de aviso.
     * - Se ocorrer um erro no servidor, exibe uma mensagem de erro.
     * 
     * Parâmetros:
     * - id_usuario: O identificador único do usuário a ser editado.
     * 
     * Uso típico:
     * - Esta função é chamada quando o usuário deseja editar suas informações, após preencher o formulário de edição.
     * - Ela valida os dados do formulário, envia a solicitação para o servidor e fornece feedback ao usuário.
     ***************************************************************************************/
    function mostrarSenha(idInput, idIcon){
        let senhaInput = $(`#${idInput}`);
        if (senhaInput.attr('type') === 'password') {
            senhaInput.attr('type', 'text');
            $(`#${idIcon}`).removeClass('glyphicon glyphicon-eye-open');
            $(`#${idIcon}`).addClass('glyphicon glyphicon-eye-close');
        } else {
            senhaInput.attr('type', 'password');
            $(`#${idIcon}`).removeClass('glyphicon glyphicon-eye-close');
            $(`#${idIcon}`).addClass('glyphicon glyphicon-eye-open');
        }
    }

    /***************************************************************************************
     * Esta função é responsável por listar os usuários do sistema com base em um filtro de tipo de acesso.
     * 
     * Como funciona:
     * - Obtém o valor do campo de seleção "tipo_acesso_filtro" que representa o tipo de acesso a ser filtrado.
     * - Realiza uma requisição AJAX para o servidor, enviando o tipo de acesso como parâmetro.
     * - O servidor retorna uma lista de usuários que correspondem ao filtro.
     * - Com base na resposta do servidor, a função cria uma tabela HTML que exibe os usuários na página.
     * - Se não houver usuários correspondentes ao filtro, exibe uma mensagem indicando que não há usuários cadastrados.
     * - Para cada usuário na resposta do servidor, a função cria uma linha na tabela com informações como email, nome de usuário e tipo de acesso.
     * - Também inclui botões de exclusão e edição para cada usuário.
     * 
     * Uso típico:
     * - Esta função é chamada quando o usuário seleciona um filtro de tipo de acesso e deseja listar os usuários correspondentes.
     * - Ela envia uma solicitação ao servidor, recebe os dados dos usuários e os exibe em uma tabela na página.
     * - Também fornece a capacidade de excluir ou editar usuários diretamente a partir da tabela.
     ***************************************************************************************/
    function listarUsuarios() {
        // Obtém o valor do campo de seleção "tipo_acesso_filtro" que representa o tipo de acesso a ser filtrado
        let tipo_acesso = $("#tipo_acesso_filtro").val();

        // Realiza uma requisição AJAX para o servidor para listar os usuários com base no filtro
        $.ajax({
            url: "<?=base_url('login/ajax_listarUsuarios')?>",
            type: "GET",
            dataType: "json",
            cache: false,
            data: {
                tipo_acesso: tipo_acesso
            },
            success: function(data) {
                // Inicializa uma variável HTML com uma mensagem padrão de "Não há usuários cadastrados"
                let html = `
                    <tr>
                        <td colspan="4">
                            Não há usuários cadastrados
                        </td>
                    </tr>
                `;

                // Verifica se o servidor retornou algum dado de usuário
                if (data.length > 0) {
                    // Se houver usuários, limpa a variável HTML padrão
                    html = '';
                    let tipoUsuario = '';

                    // Itera sobre os dados de usuário recebidos do servidor
                    data.forEach(conta => {
                        // Converte o tipo de acesso em uma descrição legível
                        switch (conta['tipo_acesso']) {
                            case '1':
                                tipoUsuario = 'Cliente';
                                break;
                            case '2':
                                tipoUsuario = 'Loja';
                                break;
                            default:
                                tipoUsuario = 'Desconhecido';
                                break;
                        }

                        // Cria uma linha na tabela para cada usuário com informações como email, nome de usuário e tipo de acesso
                        // Também inclui botões de exclusão e edição
                        html += `
                            <tr id="tr_usuario_${conta['id_usuario']}">
                                <td>
                                    ${conta['email']}
                                </td>
                                <td>
                                    ${conta['nome_usuario']}
                                </td>
                                <td>
                                    ${tipoUsuario}
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger" onclick="deletarConta('${conta['id_usuario']}')">
                                        <i class="glyphicon glyphicon-trash"></i>
                                    </button>
                                    <a class="btn btn-default" href="<?=base_url('login/editarUsuario')?>/${conta['id_usuario']}">
                                        <i class="glyphicon glyphicon-pencil"></i>
                                    </a>
                                </td>
                            </tr>
                        `;
                    });
                }

                // Atualiza o conteúdo da tabela com os usuários ou a mensagem de "Não há usuários cadastrados"
                $("#lista_contas").html(html);
            },
            error: function() {
                // Exibe uma mensagem de erro em caso de falha na comunicação com o servidor
                exibirAviso('Aconteceu um erro em nosso servidor', 'alerta_modal');
            }
        });
    }


    /***************************************************************************************
     * Esta função é responsável por abrir um modal que lista os usuários do sistema.
     * 
     * Como funciona:
     * - Chama a função listarUsuarios() para obter a lista de usuários e exibi-los no modal.
     * - Em seguida, utiliza o jQuery para mostrar o modal na tela, tornando-o visível para o usuário.
     * 
     * Uso típico:
     * - Esta função é chamada quando o usuário deseja abrir um modal que exibe a lista de usuários.
     * - Primeiro, ela lista os usuários através da função listarUsuarios() para garantir que a lista esteja atualizada.
     * - Em seguida, abre o modal para que o usuário possa visualizar a lista de usuários cadastrados.
     ***************************************************************************************/
    function abrirModalListarUsuarios() {
        // Chama a função listarUsuarios() para obter e exibir a lista de usuários
        listarUsuarios();
        
        // Utiliza o jQuery para mostrar o modal "modalContas" na tela
        $("#modalContas").modal("show");
    }

    /***************************************************************************************
     * Esta função é responsável por excluir uma conta de usuário após a confirmação do usuário.
     * 
     * Como funciona:
     * - Exibe um alerta de confirmação para garantir que o usuário deseja realmente deletar a conta.
     * - Se o usuário confirmar a exclusão, uma solicitação AJAX é enviada ao servidor para excluir a conta.
     * - Após a exclusão bem-sucedida, remove a linha correspondente na tabela de usuários.
     * - Se a tabela ficar vazia após a exclusão, exibe uma mensagem indicando que não há usuários cadastrados.
     * - Exibe mensagens de sucesso ou erro com base na resposta do servidor.
     * 
     * Parâmetros:
     * - id_usuario: O identificador único da conta de usuário a ser excluída.
     * 
     * Uso típico:
     * - Esta função é chamada quando o usuário deseja excluir uma conta de usuário.
     * - Ela exibe um alerta de confirmação para garantir que o usuário realmente deseja excluir a conta.
     * - Se o usuário confirmar, a conta é excluída, e a tabela de usuários é atualizada na página.
     * - Caso contrário, a exclusão é cancelada.
     ***************************************************************************************/
    function deletarConta(id_usuario) {
        // Exibe um alerta de confirmação para garantir que o usuário deseja deletar esta conta
        if (confirm("Tem certeza de que deseja deletar esta conta?")) {
            $.ajax({
                url: "<?=base_url('login/ajax_deletar')?>",
                type: "POST",
                dataType: "json",
                data: {
                    id_usuario: id_usuario
                },
                cache: false,
                success: function(data) {
                    if (data.sucesso) {
                        // Remove a linha correspondente na tabela de usuários
                        let trId = `tr_usuario_${id_usuario}`;
                        $(`#${trId}`).remove();
                        
                        // Verifica se a tabela de usuários ficou vazia após a exclusão
                        let quantidadeUsuario = $("#lista_contas").find("tr").length;
                        if (quantidadeUsuario == 0 || quantidadeUsuario == null) {
                            // Se vazia, exibe uma mensagem indicando que não há usuários cadastrados
                            let html = `
                                <tr>
                                    <td colspan="4">
                                        Não há usuários cadastrados
                                    </td>
                                </tr>
                            `;
                            $("#lista_contas").html(html);
                        }
                        
                        // Exibe uma mensagem de sucesso
                        exibirAviso('Usuário deletado com sucesso', 'alerta_modal_lista', 'SUCESSO');
                    } else {
                        // Exibe uma mensagem de erro em caso de falha na exclusão
                        let mensagem = 'Aconteceu um erro em nosso servidor';
                        exibirAviso(mensagem, 'alerta_modal_lista');
                        $("#senha").val('');
                    }
                },
                error: function() {
                    // Exibe uma mensagem de erro se ocorrer um erro na comunicação com o servidor
                    exibirAviso('Aconteceu um erro em nosso servidor', 'alerta_modal_lista');
                }
            });
        }
    }
</script>