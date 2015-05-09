<?php
session_start();
require_once("util/verSession.php");

require_once("util/dataSource.php");
try
{       
        $qLogin = $_SESSION["login"];
	
	$origem = basename($_SERVER['HTTP_REFERER']);
	if(($origem!='alunoForm.php?operacao=edit')){
            
            die();
	}
	
        $conexao = conn_mysql();
        
        $nomeCompleto = utf8_encode(htmlspecialchars($_POST['nomeCompleto']));
        $cidade = utf8_encode(htmlspecialchars($_POST['cidade']));
        $email = utf8_encode(htmlspecialchars($_POST['email']));
        $descricao = utf8_encode(htmlspecialchars($_POST['descricao']));

        $SQLInsert = 'UPDATE daw_yearbook.participantes
                    SET
                    nomeCompleto = ?,
                    cidade = ?,
                    email = ?,
                    descricao = ?
                    WHERE login LIKE ?;';

        $operacao = $conexao->prepare($SQLInsert);					  

        $inserir = $operacao->execute(array($nomeCompleto,$cidade,$email,$descricao,$qLogin));

        $conexao = null;
               
        if ($inserir){
            header("Location:alunoDetalhes.php?qAluno=".$qLogin);
            die();
        }else{
            echo "<h1>Erro na operação.</h1>\n";
                $arr = $operacao->errorInfo();		
                $erro = utf8_decode($arr[2]);
                echo "<p>$erro</p>";			
            echo "<p><a href=\"alunoForm.php?operacao=edit\">Retornar</a></p>\n";
        }
        
    }

catch (PDOException $e)
{
    echo "Erro!: " . $e->getMessage() . "<br>";
    die();
}

?>

