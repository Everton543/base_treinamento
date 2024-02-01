<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title> <?= $title ?? 'Treinamento'; ?> </title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
    <style>
        body {
            background-color: #eee;
        }
        main{
            margin: 2rem;
        }
    </style>
    <script>
        /***********************************************************************************************
         * Esta função exibe um aviso na página HTML, como uma mensagem de sucesso, aviso ou erro.
         *
         * Parâmetros:
         * - aviso_texto: O texto a ser exibido no aviso.
         * - div_id: O ID do elemento HTML onde o aviso será exibido.
         * - tipo_aviso (opcional): O tipo de aviso (SUCESSO, AVISO ou ERRO). Padrão é "ERRO".
         * 
         * A função cria uma div de aviso dinamicamente com base no tipo_aviso e adiciona-a ao elemento
         * com o ID especificado (div_id). O aviso é então mostrado na página e desaparece após 4 segundos.
         * A página é rolada para exibir o aviso, se necessário.
         ***********************************************************************************************/
        function exibirAviso(aviso_texto, div_id, tipo_aviso = "ERRO")
        {
            $('#' + div_id).show();
            switch(tipo_aviso){
                case "SUCESSO":{
                    $('#' + div_id).html('<div class="alert alert-success alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span></button><p >'+ aviso_texto +'</p></div>');
                    break;
                }
                case "AVISO":{
                    $('#' + div_id).html('<div class="alert alert-warning alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span></button><p >'+ aviso_texto +'</p></div>');
                    break;
                }
                default:{
                    $('#' + div_id).html('<div class="alert alert-danger alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span></button><p >'+ aviso_texto +'</p></div>');
                    break;
                }
            }
            setTimeout(() => {
                $('#' + div_id).html('');
            }, 4000);
            
            $('html, body').animate({
                scrollTop: $('#' + div_id).offset().top
            }, 0);
        }
    </script>
</head>
<body>
    <?php if($tipo_acesso != null): ?>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="<?= $homeUrl ?>">HOME</a>
                </div>

                <ul class="nav navbar-nav navbar-right">
                    
                    <?php if($tipo_acesso == '1'): ?>
                        <li>
                            <a style="cursor: pointer;">
                                <i id="icone_carrinho" class="glyphicon glyphicon-shopping-cart"></i>
                                <span id="quantidade_carrinho" class="badge badge-primary">0</span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?=$nome_usuario?> <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <?php if($tipo_acesso == '1'): ?>
                            <li><a href="#">Pedidos</a></li>
                        <?php elseif($tipo_acesso == '2'): ?>
                            <li><a href="#">Produtos</a></li>
                            <li><a href="#">Vendas</a></li>
                        <?php endif; ?>
                        <li role="separator" class="divider"></li>
                        <li><a href="<?=base_url('login/logout')?>">Logout</a></li>
                    </ul>
                    </li>
                </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>
    <?php endif; ?>
    <main>
        <?= $conteudo?>
    </main>
</body>
</html>