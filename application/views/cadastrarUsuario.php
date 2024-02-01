<style>
    .cadastro-panel {
        width: 100%;
        max-width: 500px;
        padding: 15px;
        margin: 0 auto;
        margin-top: 60px;
    }
</style>
<div class="container">
    <div class="cadastro-panel panel panel-default">
        <div class="panel-heading">
            <h1 class="panel-title text-center">Cadastro usuario</h1>
        </div>
        <div class="panel-body">
            <div id="alerta"></div>
            <div id="loginForm">
                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input class="form-control" placeholder="E-mail" id="email" type="email" maxlength="255" required autofocus>
                </div>
                <div class="form-group">
                    <label for="senha">Senha</label>
                    <input class="form-control" placeholder="Senha" id="senha" type="password"  maxlength="255" required>
                </div>
                <button type="submit" class="btn btn-lg btn-success btn-block" onclick="login()">Entrar</button>
                <a href="URL_DA_PAGINA_DE_CADASTRO" class="signup-link">Não tem uma conta? Cadastre-se</a>
            </div>
        </div>
    </div>
</div>

<script>
    function validarEmail(){
        let email = $("#email").val() ?? false;
        if(!email){
            return false;
        }
        
        let regexEmail = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
        return regexEmail.test(email);
    }

    function validarDados(){
        if(!validarEmail()){
            exibirAviso('Email invalido', 'alerta');
            return false;
        }
        //pega o valor do input senha caso seja NULL ou '' irá pegar o valor do outro lado do ??
        let senha = $("#senha").val() ?? false; 
        if(!senha){
            exibirAviso('Senha vazia', 'alerta');
            return false;
        }
        return true;
    }

    function login(){
        if(!validarDados()){
            $("#senha").val('');
            return;
        }
        let email = $("#email").val();
        let senha = $("#senha").val(); 
        $.ajax({
            url: "<?=base_url('login/autenticar')?>", // URL que será chamada a requesição
            type: "POST", // Tipo de requisição (GET, POST, etc.)
            dataType: "json", // Tipo de dados esperado na resposta
            data: { //dados que serão enviados pela requesição
                email: email,
                senha: senha
            },
            cache: false,
            success: function(data) {
                console.log(data);
            },
            error: function() {
                exibirAviso('Aconteceu um erro em nosso servidor', 'alerta');
            }
        });
    }
</script>