<?php
                            require_once("util/dataSource.php");
                            try{                        
                                $conexao = conn_mysql();

                                $SQLSelect = 'SELECT * FROM cidades WHERE cidades.idEstado = ?';
                               
                                $qEstado = utf8_encode(htmlspecialchars($_GET['qEstado']));

                                $operacao = $conexao->prepare($SQLSelect);					  
                                				
                                $pesquisar = $operacao->execute(array($qEstado));
                                
                                $resultados = $operacao->fetchAll();

                                $conexao = null;
                                
                                $dados_result = array();
                                
                                //php não calaborou e ai estamos motando o json a moda antiga
                                if (count($resultados)>0){
                                    $jsonStr='{"cidades":[';
                                    foreach($resultados as $iCidade){
                                       $jsonStr.="{\"id\":\"".utf8_encode($iCidade["idCidade"])."\",\"nome\":\"".utf8_encode($iCidade["nomeCidade"])."\"},"; 
                                    }
                                    $jsonStr = substr($jsonStr, 0,strlen($jsonStr)-1)."]}";
                                    header('Cache-Control: no-cache, must-revalidate');
                                    header('Content-type: application/json; charset=utf-8');
                                    
                                    echo $jsonStr;
                                    //echo json_encode($resultados);
                                                                        
                                }else{
                                  echo'<span class="msg-aviso">Nenhum resultado encontrado.</span>';
                                }
                            }catch (PDOException $e){
                                echo "<span class='msg-aviso'>Erro inesperado:" . $e->getMessage() . "</span>";
                                die();
                            }   

