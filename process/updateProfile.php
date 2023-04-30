<?php 
    //VERIFICANDO SE O USUARIO ESTA LOGADO
    include('check.php');

    // JA QUE INPUT EH DE IMAGEM VERIFICAMOS O TIPO DE CHAMADA
    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        //APAGANDO A FOTO ANTERIOR
        if($user_picture != 'user.jpg'){
            
            // chdir()-> changes the dir
            chdir("../profilepics/");
            //getcwd() -> gets the current dir
            if (!unlink($user_picture))
                die(header("HTTP/1.0 401 Algo de errado apagado a foto anterior"));    
        }
        //retorna a extencao em lowcase
        $imageFileType = strtolower(pathinfo($user_picture,PATHINFO_EXTENSION));
        $imagename = md5(rand(999, 999999).$_FILES['imgInp']['name'].date(DATE_RFC822)).".".$imageFileType;
        $imagetemp = $_FILES['imgInp']['tmp_name'];
        $imagepath = "../profilepics/";

        if(is_uploaded_file($imagetemp)){
            if(move_uploaded_file($imagetemp, $imagepath.$imagename)){
                $stmt = $conn->prepare("UPDATE `USER` SET `PICTURE` = ?  WHERE `ID` = ?");
                $stmt->bind_param("si", $imagename, $uid);
                $stmt->execute();
                if(!$stmt)
                    die(header("HTTP/1.0 401 Erro ao guardar imagem no BD!"));
            }
            else
                die(header("HTTP/1.0 401 Erro ao guardar imagem!"));
        }
        else
            die(header("HTTP/1.0 401 Erro no upload da imagem!"));
    }
    else
        die(header("HTTP/1.0 401 Falta parametros!"));

?>
