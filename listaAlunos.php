<?php
    session_start();
    include("util/verSession.php");
?>

<!DOCTYPE html>
<html lang="pt-br">
	
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>Lista de Alunos - Puc Minas - Desenvolvimento de Aplicações Web - Turma 2014/2015</title>
		<link rel="stylesheet" href="asset/style/standard.css">
	</head>
	
	<body>
		<?php
                        include("template/header.php");
                ?>        
		<main class="alunos-lista">
			<h1>Turma 2014/2015</h1>
                        <div class="cont-busca">
                            <form method="GET" target="listaAlunos.php">
                                <input type="search" name="filtro" placeholder="Digite o nome do aluno" />
                                <input type="submit" value="Buscar">
                            </form>
                        </div>
                        <?php
                            require_once("util/dataSource.php");
                            try{                        
                                // instancia objeto PDO, conectando no mysql
                                $conexao = conn_mysql();

                                $SQLSelect = 'SELECT nomeCompleto, arquivoFoto, login FROM participantes';

                                if(!empty($_GET['filtro'])){
                                      $nomeBusca = utf8_encode(htmlspecialchars($_GET['filtro']));
                                              $nomeBusca = "%".$nomeBusca."%";
                                              $SQLSelect .= ' WHERE nomeCompleto like ?';
                                }

                                $operacao = $conexao->prepare($SQLSelect);					  
                                if(!empty($_GET['filtro'])){				
                                    $pesquisar = $operacao->execute(array($nomeBusca));
                                }else{
                                    $pesquisar = $operacao->execute();
                                }

                                $resultados = $operacao->fetchAll();

                                $conexao = null;

                                if (count($resultados)>0){
                                    echo'<ul>';
                                    foreach($resultados as $alunosEncontrados){

                                        echo"<li>
                                                 <a href='alunoDetalhes.php?qAluno=".utf8_encode($alunosEncontrados['login'])."' title='Detalhes do Aluno ".utf8_encode($alunosEncontrados["nomeCompleto"])."'>
                                                    <figure class='sombra-leve'>
                                                            <img src='asset/image/alunos/".utf8_encode($alunosEncontrados['arquivoFoto'])."' width='240' height='320' alt='".utf8_encode($alunosEncontrados["nomeCompleto"])."'>
                                                            <figcaption>".utf8_encode($alunosEncontrados['nomeCompleto'])."</figcaption>
                                                    </figure>
                                                 </a>
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
                    
                     echo"<div class='cont-historico'>
                            <h4>Ultima Visualização</h4>
                            <a class='link-historico' href='alunoDetalhes.php?qAluno=".$userUlt."'><img src='asset/image/alunos/".$fotoUlt."' /><span>".$nomeUlt."</span></a>
                        </div>";
                    }
            ?>
		</main>
	
		<?php
                    include("template/footer.html");
                ?>   
		
	</body>
</html>