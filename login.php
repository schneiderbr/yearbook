<?php
        session_start();
        try{
                require_once("util/dataSource.php");
		
                $origem = basename($_SERVER['HTTP_REFERER']);
                
                $aux = explode("?", $origem);
                $origemGet= $aux[0];
                                
                echo "origem:".$origem;
                echo "<br>origemGet:".$origemGet;
                
                                
                if(!(isset($_POST["senha"]) && isset($_POST["login"]))){
                     header("Location: index.php?erro=Usuário ou senha invalidos");
                    die();
                }
                
                $senha = utf8_encode(htmlspecialchars($_POST["senha"]));
                $login = utf8_encode(htmlspecialchars($_POST["login"]));
                
		$conexao = conn_mysql();
				
		$SQLSelect = 'SELECT * FROM participantes WHERE senha=MD5(?) AND login=?';

                $operacao = $conexao->prepare($SQLSelect);					  
				
		$pesquisar = $operacao->execute(array($senha, $login));
		
		$resultados = $operacao->fetchAll();
		
		$conexao = null;
		
		if (count($resultados)!=1){	
                    header("Location: index.php?erro=Usuário ou senha invalidos");
                    die();
		}   
		else{ 
			
		   $_SESSION['auth']=true;
		   $_SESSION['login'] = $login;
                   $_SESSION['nomeCompleto'] = $resultados[0]["nomeCompleto"];
		   header("Location: listaAlunos.php");
		   die();
		}
	} 
	catch (PDOException $e)
	{
		// caso ocorra uma exceção, exibe na tela
		echo "Erro!: " . $e->getMessage() . "<br>";
		die();
	}
?>