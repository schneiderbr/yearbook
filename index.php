<!DOCTYPE html>
<html lang="pt-br">
	
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>Lista de Alunos - Puc Minas - Desenvolvimento de Aplicações Web - Turma 2014/2015</title>
		<link rel="stylesheet" href="asset/style/standard.css">
	</head>
	
	<body>
		<?php
                        include("template/headeroff.html");
                ?>        
		<main class="alunos-home">
                    <section class="home-lista">
                        <?php
                            require_once("util/dataSource.php");
                            try{                        
                                // instancia objeto PDO, conectando no mysql
                                $conexao = conn_mysql();

                                $SQLSelect = 'SELECT nomeCompleto, arquivoFoto, login FROM participantes ORDER BY RAND() limit 10';
                               
                                $operacao = $conexao->prepare($SQLSelect);					  
                                
                                $pesquisar = $operacao->execute();

                                $resultados = $operacao->fetchAll();

                                $conexao = null;

                                if (count($resultados)>0){
                                    echo'<ul>';
                                    foreach($resultados as $alunosEncontrados){

                                        echo"<li>
                                                    <img src='asset/image/alunos/".utf8_encode($alunosEncontrados['arquivoFoto'])."' width='48' height='64' alt='".utf8_encode($alunosEncontrados["nomeCompleto"])."'>
                                                 
                                            </li>";
                                    }        
                                    echo'</ul>';
                                }else{
                                  echo'<span class="msg-aviso">Nenhum resultado encontrado.</span>';
                                }
                            }catch (PDOException $e){
                                echo "<span class='msg-aviso'>Erro inesperado:" . $e->getMessage() . "</span>";
                                die();
                            }   
                                             
                   
                            if(isset($_COOKIE["nomeUlt"]) & isset($_COOKIE["userUlt"]) & isset($_COOKIE["fotoUlt"])){    
                                $nomeUlt = $_COOKIE["nomeUlt"];
                                $userUlt = $_COOKIE["userUlt"];
                                $fotoUlt = $_COOKIE["fotoUlt"];

                            }
                ?>
                    </section>
                    <section>
                        <form class="form-aluno" method="POST" action="login.php">
                            <div class="linha-form">     
                                <label>Usuário</label>
                                <input name="login" type="text" required  />
                            </div>
                            <div class="linha-form">     
                                <label>Senha</label>
                                <input name="senha" type="password" required  maxlength="10"/>
                            </div>
                            <div class="linha-form cont-bt">     
                                <input type="submit" value="Logar"  />
                                <input type="button" value="Criar Conta" onclick="document.location='alunoForm.php'">
                            </div> 
                        </form>    
                    </section>   
		</main>
	
		<?php
                    include("template/footer.html");
                    
                    if(isset($_GET["erro"])){
                        echo"<div class='msg-erro'><p>".$_GET["erro"]."</p></div>";
                    }
                    
                ?>   
		
	</body>
</html>