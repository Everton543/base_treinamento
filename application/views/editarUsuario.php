<style>
    .panel{
        max-width: 700px;
        margin: 0 auto;
    }
</style>
<div class="panel panel-primary">
    <div class="panel-heading">
        <h1>Editar Usuário</h1>
    </div>
    <div class="panel-body">
        <div class="container col-lg-12 col-md-12 col-sm-12">
            <div id="alerta"></div>
            <div class="form-group col-lg-6 col-md-6 col-sm-12">
                <label for="email_edicao">E-mail</label>
                <input class="form-control" placeholder="E-mail" id="email_edicao" type="email" maxlength="255" readonly
                    value="<?=$usuario['email']?>"
                >
            </div>
            <div class="form-group col-lg-6 col-md-6 col-sm-12">
                <label for="senha">Senha</label>
                <input class="form-control" placeholder="Senha" id="senha_edicao" type="password"  maxlength="255"
                value="">
                <span id="olho_senha" class="glyphicon glyphicon-eye-open" onclick="mostrarSenha('senha_edicao', 'olho_senha')" style="position: relative; top: -25px; left: 94%; cursor: pointer;"></span>
            </div>
            <div class="form-group col-lg-6 col-md-6 col-sm-12">
                <label for="nome_usuario"><span class="glyphicon glyphicon-flag"></span> Nome</label>
                <input class="form-control" placeholder="Nome" id="nome_usuario" type="text"
                    maxlength="255" required value="<?=$usuario['nome_usuario']?>"
                >
            </div>
            <div class="form-group col-lg-6 col-md-6 col-sm-12">
                <label for="tipo_acesso"><span class="glyphicon glyphicon-flag"></span> Tipo Acesso</label>
                <select class="form-control" id="tipo_acesso" required>
                    <?php foreach($acessos as $acesso) : ?>
                        <option value="<?=$acesso['id']?>" <?=($acesso['id'] == $usuario['tipo_acesso']) ? 'selected': '';?>><?=$acesso['tipo']?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </div>
    <div class="panel-footer" style="text-align: right;">
        <a style="margin-right: 0.5rem;" class="btn btn-default btn-lg" href="<?=base_url()?>">Voltar</a>
        <button type="button" style="margin-right: 3rem;" class="btn btn-primary btn-lg" onclick="editarUsuario('<?=$usuario['id_usuario']?>')">Editar</button>
    </div>
</div>
<script>
    /***************************************************************************************
     * Esta função é responsável por validar os dados de edição de um usuário.
     * 
     * Parâmetros:
     * - nome_usuario: O nome do usuário que está sendo editado.
     * 
     * Como funciona:
     * - Verifica se o nome do usuário não é nulo (null) e não está vazio ('').
     * - Se o nome do usuário for nulo ou vazio, exibe um aviso de que o nome não pode ser vazio e retorna falso.
     * - Se o nome do usuário for válido, retorna verdadeiro, indicando que os dados estão corretos.
     * 
     * Uso típico:
     * - Antes de enviar uma solicitação de edição de usuário, você pode chamar esta função para garantir que o nome do 
     * usuário seja válido.
     * - Se a função retornar verdadeiro, os dados são considerados válidos e você pode prosseguir com a edição.
     * - Se a função retornar falso, você deve interromper a edição e exibir uma mensagem de erro ao usuário.
     ***************************************************************************************/
    function validarDadosEditar(nome_usuario) {
        // Pega o valor do input senha caso seja NULL ou '' irá pegar o valor do outro lado do ??
        nome_usuario = nome_usuario ?? false; 

        if (!nome_usuario) {
            // Exibe um aviso se o nome do usuário for vazio ou nulo
            exibirAviso('Nome não pode ser vazio', 'alerta');
            return false;
        }

        // Retorna verdadeiro se o nome do usuário for válido
        return true;
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
    function editarUsuario(id_usuario){
          // Obtém os valores dos campos de senha, nome de usuário e tipo de acesso do formulário
        let senha = $("#senha_edicao").val();
        let nome_usuario = $("#nome_usuario").val();
        let tipo_acesso = $("#tipo_acesso").val();
        
         // Verifica se os dados de cadastro são válidos usando a função validarDadosEditar()
        if(!validarDadosEditar(nome_usuario)){
            // Limpa o campo de senha se os dados forem inválidos e encerra a função
            $("#senha_edicao").val('');
            return;
        }
        
        // Envia uma solicitação AJAX para o servidor para editar o usuário com os dados fornecidos
        $.ajax({
            url: "<?=base_url('login/ajax_editarUsuario')?>",
            type: "POST",
            dataType: "json",
            data: {
                senha: senha,
                nome_usuario: nome_usuario,
                tipo_acesso: tipo_acesso,
                id_usuario: id_usuario
            },
            cache: false,
            success: function(data) {
                if(data.sucesso){
                    // Exibe uma mensagem de sucesso se a edição for bem-sucedida
                    exibirAviso('Usuário editado com sucesso', 'alerta', 'SUCESSO');
                    // Limpa o campo de senha
                    $("#senha_edicao").val('');
                }else{
                    // Exibe uma mensagem de aviso se nada for alterado no usuário
                    exibirAviso('Nada foi alterado no usuário', 'alerta', 'AVISO');
                    // Limpa o campo de senha
                    $("#senha_edicao").val('');
                }
            },
            error: function() {
                // Exibe uma mensagem de erro se ocorrer um erro no servidor
                exibirAviso('Aconteceu um erro em nosso servidor', 'alerta');
            }
        });
    }

    /***************************************************************************************
     * Esta função é responsável por alternar a visibilidade da senha em um campo de entrada de senha.
     * 
     * Como funciona:
     * - Recebe dois parâmetros: o primeiro é o ID do campo de entrada de senha e o segundo é o ID do ícone de 
     * exibição/ocultação da senha.
     * - Verifica o tipo do campo de entrada de senha (password ou text).
     * - Se o campo estiver definido como 'password', ele muda para 'text' para mostrar a senha.
     *   - Também atualiza o ícone para indicar que a senha está sendo exibida.
     * - Se o campo estiver definido como 'text', ele muda de volta para 'password' para ocultar a senha.
     *   - Também atualiza o ícone para indicar que a senha está sendo ocultada.
     * 
     * Parâmetros:
     * - idInput: O ID do campo de entrada de senha que será alternado.
     * - idIcon: O ID do ícone que será atualizado para indicar a visibilidade da senha.
     * 
     * Uso típico:
     * - Esta função é chamada quando o usuário clica em um ícone de exibição/ocultação de senha.
     * - Ela permite que o usuário revele a senha digitada no campo de senha ou a oculte, proporcionando uma 
     * experiência amigável ao usuário.
     ***************************************************************************************/
    function mostrarSenha(idInput, idIcon) {
        let senhaInput = $(`#${idInput}`);
        if (senhaInput.attr('type') === 'password') {
            // Altera o tipo do campo de senha para 'text' para mostrar a senha
            senhaInput.attr('type', 'text');
            // Atualiza o ícone para indicar que a senha está sendo exibida
            $(`#${idIcon}`).removeClass('glyphicon glyphicon-eye-open');
            $(`#${idIcon}`).addClass('glyphicon glyphicon-eye-close');
        } else {
            // Altera o tipo do campo de senha de volta para 'password' para ocultar a senha
            senhaInput.attr('type', 'password');
            // Atualiza o ícone para indicar que a senha está sendo ocultada
            $(`#${idIcon}`).removeClass('glyphicon glyphicon-eye-close');
            $(`#${idIcon}`).addClass('glyphicon glyphicon-eye-open');
        }
    }
</script>