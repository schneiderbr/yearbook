<?php
session_start();
require_once("util/verSession.php");

require_once("util/dataSource.php");
require_once("util/upLoadFoto.php");


try
{
	
	$origem = basename($_SERVER['HTTP_REFERER']);
	if(($origem!='alunoForm.php')){
            echo'Aqui não truta,  tambem sou do movimento...';
            die();
	}
	
        $conexao = conn_mysql();
        
        $login = utf8_encode(htmlspecialchars($_POST['login']));
        $senha = utf8_encode(htmlspecialchars($_POST['senha']));
        $nomeCompleto = utf8_encode(htmlspecialchars($_POST['nomeCompleto']));
        $cidade = utf8_encode(htmlspecialchars($_POST['cidade']));
        $email = utf8_encode(htmlspecialchars($_POST['email']));
        $descricao = utf8_encode(htmlspecialchars($_POST['descricao']));
        $nomeFoto=upload($login);
        if(!$nomeFoto){
            echo "Erro!: Arquivo invalido, a foto deve ser no formato .png ou .jpge e ter no maximo 4MB.<br>";
            die();
        }

        $SQLInsert = 'INSERT INTO `daw_yearbook`.`participantes`
                        (`login`,`senha`,`nomeCompleto`,`arquivoFoto`,`cidade`,`email`,`descricao`)
                        VALUES
                        (?,MD5(?),?,?,?,?,?);';


        $operacao = $conexao->prepare($SQLInsert);					  

        $inserir = $operacao->execute(array($login, $senha,$nomeCompleto,$nomeFoto,$cidade,$email,$descricao));

        $conexao = null;
        
        if ($inserir){
            header("Location:index.php?erro=Cadasto realizado com sucesso, por favor faça o seu login.");
            die();
        }else{
            echo "<h1>Erro na operação.</h1>\n";
                $arr = $operacao->errorInfo();		//mensagem de erro retornada pelo SGBD
                $erro = utf8_decode($arr[2]);
                echo "<p>$erro</p>";			//deve ser melhor tratado em um caso real
            echo "<p><a href=\"./alunoForm.php\">Retornar</a></p>\n";
        }
        
        echo "fim:".$inserir;
    }

catch (PDOException $e)
{
    // caso ocorra uma exceção, exibe na tela
    echo "Erro!: " . $e->getMessage() . "<br>";
    die();
}

?>

