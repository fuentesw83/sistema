<?php

function isNull ($nombre, $user, $pass, $pass_con, $email) {
    if(strlen(trim($nombre)) < 1 || strlen(trim($user)) < 1 || strlen(trim($pass)) < 1 || strlen(trim($pass_con)) < 1 || strlen(trim($email)) < 1){
        return true;
    }else{
        return false;
    }
}

function isEmail($email){
    if (filter_var($email, FILTER_VALIDATE_EMAIL)){
        return true;
    }else{
        return false;
    }
}

function validaPassword($var1, $var2){
    if (strcmp($var1, $var2) !== 0){
        return false;
    }else{
        return true;
    }
}

function minMax($min, $max, $valor){
    if(strlen(trim($valor)) < $min){
        return true;
    }else if(strlen(trin($valor)) > $max){
        return true;
    }else{
        return false;
    }
}

function usuarioExiste($usuario){
    global $mysqli;

    $stmt = $mysqli->prepare("SELECT id FROM usuarios WHERE usuario = ? LIMIT 1");
    $stmt = bind_param("s", $usuario);
    $stmt->execute();
    $stmt->store_result();
    $num = $stmt->num_rows;
    $stmt->close();

    if($num > 0){
        return true;
    }else {
        return false; 
    }
}

function emailExiste($email){

    global $mysqli;

    $stmt = $mysqli->prepare("SELECT id FROM usuarios WHERE correo = ? LIMIT 1");
    $stmt = bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $num = $stmt->num_rows;
    $stmt->close();

    if($num > 0){
        return true;
    }else {
        return false; 
    }

}

function generateToken(){
    $gen = md5(uniqid(mt_rand(), false));
    return $gen;
}

function hashPassword($password){

    $hash = password_hash($password, PASSWORD_DEFAULT);
    return $hash;

}

function resultBlock($errors){
    if(count($errors) > 0){

        echo "<div id='error' class='alert alert-danger' role='alert'><a href='#' onclick=\"showHide('error');\">[X]</a><ul>";
        foreach($errors as $error){
            echo "<li>".$error."</li>";
        }
        echo "</ul>";
        echo "</div>";
    }
}

function registraUsuario($usuario, $pass_hash, $nombre, $email, $activo, $token, $tipo_usuario){

    global $mysqli;

    $stmt = $mysqli->prepare("INSERT INTO usuarios (usuario, password, nombre, correo, activacion, token, id_tipo) VALUES (?,?,?,?,?,?,?)");
    $stmt->bind_param('ssssisi', $usuario, $pass_hash, $nombre, $email, $activo, $token, $tipo_usuario);

    if($stmt->execute()){
        return $mysqli->insert_id;
    }else{
        return 0;
    }

}

function enviarEmail($email, $nombre, $asunto, $cuerpo){

    require '../PHPMailer-master/src/PHPMailer.php';
    require '../PHPMailer-master/src/SMTP.php';
    require '../PHPMailer-master/src/Exception.php';

    $mail = new PHPMailer\PHPMailer\PHPMailer;
    $mail-> isSMTP();
    $mail-> SMTPAuth = true;
    $mail-> SMTPSecure = 'tipo de seguridad';
    $mail-> Host = 'smtp.hostinger.com';
    $mail-> Port = '587';

    $mail-> Usernamer = 'support@ibotcoinsfs.com';
    $mail-> Password = 'Ibotcoins.01';

    $mail-> setFrom('support@ibotcoinsfs.com', 'IbotCoins Support');
    $mail-> addAddress($email, $nombre);

    $mail-> Subject = $asunto;
    $mail-> Body = $cuerpo;
    $mail-> IsHTML(true);

    if($mail->send())
    return true;
    else
    return false;
    

}


function isNullLogin($usuario, $password){
    if(strlen(trim($usuario)) < 1 || strlen(trim($password)) < 1){

        return true;

    }else{
        return false;
    }
}

function login($usuario, $password){

    global $mysqli;

    $stmt = $mysqli->prepare("SELECT id, id_tipo, password FROM usuarios WHERE usuario = ? || correo = ? LIMIT 1");
    $stmt->bind_param("ss", $usuario, $usuario);
    $stmt->execute();
    $stmt->store_result();
    $rows = $stmt->num_rows;

    if($rows > 0) {

        if(isActivo($usuario)){

            $stmt->bind_result($id, $id_tipo, $passwd);
            $stmt->fetch();

            $validaPassw = password_verify($password, $passwd);

            if($validaPassw){
                lastSession($id);
                $_SESSION['id_usuario'] = $id;
                $_SESSION['tipo_usuario'] = $id_tipo;

                header('Location:principal.php');
            }else{
                 echo "Wrong Password";
            }

        }else{
            $errors = "Not Activate User";
        }
    }else{
        $errors = "User not exist";
    }

    return $errors;
}

function lastSession($id){

    global $mysqli;

    $stmt = $mysqli->prepare("UPDATE usuarios SET last_session=NOW(), token_password='', password_request=1 WHERE id = ?");
    $stmt->bind_param('s', $id);
    $stmt->execute();
    $stmt->close();
}

function isActivo($usuario){

    global $mysqli;

    $stmt = $mysqli->prepare("SELECT activacion FROM usuarios WHERE usuario = ? || correo = ? LIMIT 1");
    $stmt->bind_param('ss', $usuario, $usuario);
    $stmt->execute();
    $stmt->bind_result($activacion);
    $stmt->fetch();

    if($activacion == 1){
        return true;
    }else{
        return false;
    }

}