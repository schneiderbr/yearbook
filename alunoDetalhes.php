<?php
    session_start();
    require_once("util/verSession.php");
?>
<!DOCTYPE html>
<html lang="pt-br">
	
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>Puc Minas - Detalhes do Aluno Jonathan Schneider </title>
		<link rel="stylesheet" href="asset/style/standard.css">
	</head>
	
	<body>
            <?php
                    include("template/header.php");
            ?>  

            <main class="alunos-detalhes">
                
                 <?php
                            require_once("util/dataSource.php");
                            try{
                                
                                 if(empty($_GET['qAluno'])){
                                        throw new PDOException("URL mal formatada, aluno não encontado");                               
                                 }
                                
                                $conexao = conn_mysql();

                                $SQLSelect = 'SELECT * FROM participantes, cidades, estados WHERE participantes.cidade = cidades.idCidade AND estados.idEstado = cidades.idEstado AND login like ?';
                                
                                $nomeBusca = utf8_encode(htmlspecialchars($_GET['qAluno']));

                                $operacao = $conexao->prepare($SQLSelect);					  
                                
                                $pesquisar = $operacao->execute(array($nomeBusca));

                                $resultados = $operacao->fetchAll();

                                $conexao = null;

                                if (count($resultados)>0){
                                    
                                    $resultado = $resultados[0];

                                        echo"   <h1>Detalhes do Aluno ".utf8_encode($resultado["nomeCompleto"])."</h1>
                                                <div class='cont-detalhes' itemscope itemtype='http://schema.org/Person'>

                                                    <div class='aluno-dados'>
                                                        <p class='aluno-nome'><span itemprop='givenName'>".utf8_encode($resultado["nomeCompleto"])."</span></p>
                                                        <span itemprop='homeLocation' itemscope itemtype='http://schema.org/Place'>
                                                            <span itemprop='address' itemscope itemtype='http://schema.org/PostalAddress'>
                                                                <p class='aluno-loca'><span itemprop='addressLocality'>".utf8_encode($resultado["nomeCidade"])."</span>  <span itemprop='addressRegion'>".utf8_encode($resultado["nomeEstado"])."</span></p>
                                                            </span>
                                                        </span>
                                                        <a itemprop='email' href='mailto:".utf8_encode($resultado["email"])."' class='aluno-email'>".utf8_encode($resultado["email"])."</a>
                                                    </div>

                                                    <div itemprop='description' class='aluno-bio'>
                                                        <p>".utf8_encode($resultado["descricao"])."</p>
                                                    </div>

                                                    <figure class='aluno-foto'>
                                                            <img itemprop='image' src='asset/image/alunos/".utf8_encode($resultado["arquivoFoto"])."' width='240' height='320'	alt='".utf8_encode($resultado["nomeCompleto"])."'>
                                                    </figure>

                                                </div>";
                                        
                                        $validade = time() + 30*24*60*60; 
                                        setcookie("nomeUlt", utf8_encode($resultado["nomeCompleto"]), $validade);
                                        setcookie("userUlt", utf8_encode($resultado["login"]), $validade);
                                        setcookie("fotoUlt", utf8_encode($resultado["arquivoFoto"]), $validade);
                                }else{
                                  echo'<span class="msg-aviso">Nenhum resultado encontrado.</span>';
                                }
                            }catch (PDOException $e){
                                echo "<span class='msg-aviso'>Erro inesperado:" . $e->getMessage() . "</span>";
                               
                            }   
                        ?>
            </main>
            <?php
                include("template/footer.html");
            ?>  

	</body>
</html>