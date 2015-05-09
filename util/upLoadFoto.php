<?php

function upload($nomeArquivo){
    $permissoes = array("gif", "jpeg", "jpg", "png", "image/gif", "image/jpeg", "image/jpg", "image/png");  //strings de tipos e extensoes validas
    
    $temp = explode(".", basename($_FILES["fileName"]["name"]));
    $extensao = end($temp);

    if (!((in_array($extensao, $permissoes))&& (in_array($_FILES["fileName"]["type"], $permissoes))&& ($_FILES["fileName"]["size"] < $_POST["MAX_FILE_SIZE"]))){
        return false;
    }    
    if ($_FILES["fileName"]["error"] > 0){
        return false;
    }else{
	  $dirUploads = "asset/image/alunos/";
      	  	  			
    $pathCompleto = $dirUploads.basename($nomeArquivo.".".$extensao);
    
    if(move_uploaded_file($_FILES["fileName"]["tmp_name"], $pathCompleto))
        return $nomeArquivo.".".$extensao;
    else{
        return false;
    } 
}
}

?>
