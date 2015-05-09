<?php
    session_start();
    
    $userSession ="";
    $edit = false;
    
    if(isset($_GET["operacao"])){
        require_once("util/verSession.php");
        $userSession = $_SESSION["login"];
        $edit = true;
        
        require_once("util/dataSource.php");
            try{

                

                $conexao = conn_mysql();

                $SQLSelect = 'SELECT * FROM participantes, cidades, estados WHERE participantes.cidade = cidades.idCidade AND estados.idEstado = cidades.idEstado AND login like ?';

                $operacao = $conexao->prepare($SQLSelect);					  

                $pesquisar = $operacao->execute(array($userSession));

                $resultados = $operacao->fetchAll();

                $conexao = null;

                $resultado = $resultados[0];

                $nomeCompleto = $resultado["nomeCompleto"];
                $email = $resultado["email"]; 
                $descricao = $resultado["descricao"];
                $idCidade = $resultado["idCidade"];
                $idEstado = $resultado["idEstado"];
                                        
                                           
            }catch (PDOException $e){
                echo "<span class='msg-aviso'>Erro inesperado:" . $e->getMessage() . "</span>";

            }   
    }
?>


<!DOCTYPE html>
<html lang="pt-br">
	
	<head>
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
            <title>Puc Minas - Detalhes do Aluno Jonathan Schneider </title>
            <link rel="stylesheet" href="asset/style/standard.css">
            <style>
                <?php
                if($edit){
                   echo".no-edit{display:none}";     
                }
                ?>
                
            </style>
            
	</head>
	
	<body>
            <?php
                if($edit){
                    include("template/header.php");
                }else{
                    include("template/headeroff.html");
                }    
            ?> 

            <main class="alunos-form">
                <?php
                    if($edit){
                        echo"<h1>Alteração do cadastro do Aluno ".$nomeCompleto."</h1>";
                    }else{
                        echo"<h1>Novo Cadastro</h1>"; 
                    }        
                ?>    
                <div class="cont-detalhes" itemscope itemtype="http://schema.org/Person">
                    <?php
                        if($edit){
                            echo'<form id="form-aluno" class="form-aluno"  action="alunoUpdate.php" method="POST">';
                        }else{
                            echo'<form id="form-aluno" class="form-aluno"  enctype="multipart/form-data" action="alunoSave.php" method="POST">'; 
                        }        
                    ?>            
                    
                        <input type="hidden" name="MAX_FILE_SIZE" value="4194304" />
                        <div class="linha-form">    
                            <label>Nome</label>
                            <input id="nomeCompleto" name="nomeCompleto" type="text" required placeholder="O seu nome completo" />
                        </div>    
                        <div class="linha-form">    
                            <label>E-mail</label>
                            <input id="email" name="email" type="text" required placeholder="Informe seu e-mail principal" />
                         </div>    
                        <div class="linha-form no-edit">     
                            <label>Usuário</label>
                            <input name="login" type="text" required placeholder="Será utilizado para logar no sistema" />
                         </div>
                        <div class="linha-form no-edit">     
                            <label>Senha</label>
                            <input name="senha" type="password" required placeholder="Informe uma senha entre 6 e 10 digitos" maxlength="10"/>
                         </div> 
                        <div class="linha-form">     
                            <label>Descriação</label>
                            <textarea id="descricao" name="descricao" required placeholder="Escreve uma breve descrição sobre você" ></textarea>
                         </div>    
                        <div class="linha-form"> 
                            <label>Estado</label>
                            <select id="select-estado" onchange="getCidades()">
                                <option value="1">SP</option>
                                <option value="2">MG</option>
                            </select>
                         </div>    
                        <div class="linha-form"> 
                            <label>Cidade</label>
                            <select id="select-cidade" name="cidade">
                                <option value="1">MG</option>
                            </select>
                         </div>    
                        <div class="linha-form no-edit">     
                            <label>Foto</label>
                            <input type="file" name="fileName" title="Sua imagem de perfil"/>
                        </div>

                        <div class="linha-form">
                            <label>&nbsp;</label>
                            <input type="submit" value="Salvar" />
                            <input type="reset" value="Limpar" />
                        </div>  
                    </form>
                     <?php
                        if($edit){
                    ?>
                            <form id="form-delete" class="form-aluno" method="GET" action="alunoDelete.php" style="width:800px;margin:auto">
                                <div class="linha-form">     
                                    <label>Cadastro</label>
                                    <input type="submit" value="Excluir meu cadastro do sistema" />
                                </div>
                            </form>
                    <?php
                        }
                    ?>

                </div>

            </main>

            <footer>
                    <div class="line-footer">
                            <small>Atividade 5 - Desenvolvimento de Aplicações Web - Jonathan Schneider</small>
                    </div>
            </footer>
		
        <script type="text/javascript">
        
        
        
        
                        
        function getCidades(){
            
            var qEstado = document.getElementById("select-estado").value;
            
            var selectCidade = document.getElementById("select-cidade");
            
            for(key in selectCidade.options){
                selectCidade.options[key]=null;
            }
            
            var xmlhttp=new XMLHttpRequest();
                        
            xmlhttp.onreadystatechange=function(){
                if (xmlhttp.readyState==4 && xmlhttp.status==200){
                    var jsonResponse = eval("("+xmlhttp.responseText+")");
                    console.log(jsonResponse.cidades);
                    with (jsonResponse){
                        for(key in cidades){
                            var option = document.createElement("option");
                            option.text = cidades[key].nome;
                            option.value = cidades[key].id;
                            selectCidade.add(option);
                        }
                    }
                }
            }
            xmlhttp.open("GET","cidadeByEstado.php?qEstado="+qEstado,true);
            xmlhttp.send();
        }
         function limpaClasse(matchClass) {
                var elems = document.getElementsByTagName('*'), i;
                for (i in elems) {
                    if((' ' + elems[i].className + ' ').indexOf(' ' + matchClass + ' ')
                            > -1) {
                        elems[i].innerHTML = null;
                    }
                }
            }
         <?php
         
         
         
            if($edit){
                echo 'limpaClasse(\'no-edit\');';
                echo"
                    document.getElementById('nomeCompleto').value = '{$nomeCompleto}';
                    document.getElementById('email').value = '{$email}';
                    document.getElementById('descricao').value = '{$descricao}';
                    document.getElementById('select-estado').value = '{$idEstado}';
                    document.getElementById('select-cidade').value = '{$idCidade}';";
            } 
        ?>   
        
        
        
        getCidades();
        </script>    
        
        
	</body>
</html>