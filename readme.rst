###################
Projeto Criado por Everton Alves
###################
Este projeto é a base que será usada para treinar futuros estagiários da
empresa ANS Sistemas.
O objetivo é ter a base com exemplos de estilo de código usado pela empresa 
com o objetivo que futuros estagiários tentem resolver problemas de lógicas
e aprender a usar as tecnologias que utilizamos na empresa.

###################
Primeiros passos
###################
1- Instale o XAMPP versão 7.2.34, onde com o Control Panel aberto aparece o nome da versão 3.2.4
2- Clone este projeto no seu computador
3- Abrindo o Control Panel do XAMPP, clique em Config na linha do Apache
4- Clique em Apache (httpd.conf)
5- No documento de texto aperto pesquise por "htdocs"
6- Copie o trecho:
	DocumentRoot "C:/xampp/htdocs" <br>
	<Directory "C:/xampp/htdocs">
7- Cole o texto copiado abaixo do anterior
8- Coloque # na frente do anterior como no exemplo:
	#DocumentRoot "C:/xampp/htdocs" <br>
	#<Directory "C:/xampp/htdocs">
9- Substitua o caminho "C:/xampp/htdocs" tanto em DocumentRoot como em <Directory pelo caminho que está o projeto clonado no seu computador
	 Exemplo:
	 		DocumentRoot "C:/Users/NOME_DO_USUARIO/Documents/GitHub/base_treinamento"
			<Directory "C:/Users/NOME_DO_USUARIO/Documents/GitHub/base_treinamento">
10- No Control Panel do XAMPP Click em Start no Apache e no MySQL
11- No Control Panel do XAMPP Click em Admin em MySQL que irá abrir o phpmyadmin
12- No phpmyadmin crie um banco de dados com o nome "treinamento"
13- Com o novo banco de dados selecionado, clique em Importar no menu superior do phpmyadmin
14- Clique em Escolher arquivo
15- Na janela para escolher o arquivo que será utilizado, navegue até o arquivo base que foi clonado do projeto e selecione
	  o arquivo treinamento.sql (pode aparecer com apenas o nome treinamento).
16- Com ele selecionado click em Abrir
17- Desça na página até aparecer o botão Executar na parte inferior.
18- Click no botão Executar


###################
What is CodeIgniter
###################

CodeIgniter is an Application Development Framework - a toolkit - for people
who build web sites using PHP. Its goal is to enable you to develop projects
much faster than you could if you were writing code from scratch, by providing
a rich set of libraries for commonly needed tasks, as well as a simple
interface and logical structure to access these libraries. CodeIgniter lets
you creatively focus on your project by minimizing the amount of code needed
for a given task.

*******************
Release Information
*******************

This repo contains in-development code for future releases. To download the
latest stable release please visit the `CodeIgniter Downloads
<https://codeigniter.com/download>`_ page.

**************************
Changelog and New Features
**************************

You can find a list of all changes for each release in the `user
guide change log <https://github.com/bcit-ci/CodeIgniter/blob/develop/user_guide_src/source/changelog.rst>`_.

*******************
Server Requirements
*******************

PHP version 5.6 or newer is recommended.

It should work on 5.3.7 as well, but we strongly advise you NOT to run
such old versions of PHP, because of potential security and performance
issues, as well as missing features.

************
Installation
************

Please see the `installation section <https://codeigniter.com/user_guide/installation/index.html>`_
of the CodeIgniter User Guide.

*******
License
*******

Please see the `license
agreement <https://github.com/bcit-ci/CodeIgniter/blob/develop/user_guide_src/source/license.rst>`_.

*********
Resources
*********

-  `User Guide <https://codeigniter.com/docs>`_
-  `Language File Translations <https://github.com/bcit-ci/codeigniter3-translations>`_
-  `Community Forums <http://forum.codeigniter.com/>`_
-  `Community Wiki <https://github.com/bcit-ci/CodeIgniter/wiki>`_
-  `Community IRC <https://webchat.freenode.net/?channels=%23codeigniter>`_

Report security issues to our `Security Panel <mailto:security@codeigniter.com>`_
or via our `page on HackerOne <https://hackerone.com/codeigniter>`_, thank you.

***************
Acknowledgement
***************

The CodeIgniter team would like to thank EllisLab, all the
contributors to the CodeIgniter project and you, the CodeIgniter user.
