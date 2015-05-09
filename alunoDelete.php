<?php
session_start();
require_once("util/verSession.php");

require_once("util/dataSource.php");
try
{       
        $qLogin = $_SESSION["login"];
	
	$origem = basename($_SERVER['HTTP_REFERER']);
	if(($origem!='alunoForm.php?operacao=edit')){
            echo'Aqui não truta, tbm sou do movimento';
            die();
	}
	
        $conexao = conn_mysql();
              
        $SQLDelete = 'DELETE FROM participantes WHERE login LIKE ?;';

        $operacao = $conexao->prepare($SQLDelete);					  

        $inserir = $operacao->execute(array($qLogin));

        $conexao = null;
               
        if ($inserir){
            
            foreach($_COOKIE as $nome=>$valor){
                setcookie($nome, "", time()-1000);
            }
            header("Location:index.php?erro=Cadastro excluido com sucesso");
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

