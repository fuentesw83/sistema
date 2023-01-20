<?php

    require "conection.php";
    require "funcs.php";

    $errors = array();

    if(!empty($_POST)){
        
        $nombre = $mysqli->real_escape_string($_POST['nombre']);
        $usuario = $mysqli->real_escape_string($_POST['usuario']);
        $email = $mysqli->real_escape_string($_POST['email']);
        $password = $mysqli->real_escape_string($_POST['password']);
        $con_password = $mysqli->real_escape_string($_POST['con_password']);    
        $captcha = $mysqli->real_escape_string($_POST['g-recaptcha-response']);

        $activo = 1;
        $tipo_usuario = 2;
        $secret = '6LdEGvIjAAAAAAuVqz2vtLxd4akC_8_NVFTld40p';

        if(!$captcha){
            $errors[] = "Validate Captcha";
        }

        if (isNull($nombre, $usuario, $password, $con_password, $email)){
            $errors[] = "Please fill all fields";
        }

        if(!isEmail($email)){
            $errors[] = "Invalid email";
        }

        if(!validaPassword($password, $con_password)){
            $errors[] = "Password do not match";
        }

        // if(usuarioExiste($usuario)){
        //     $errors[] = "The user $usuario already exists";
        // }

        // if(emailExiste($email)){
        //     $errors[] = "The email $email already exists";
        // }

        if(count($errors) == 0){

            // $ip = $_SERVER['REMOTE_ADDR'];
            
            $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$captcha");

            $arr = json_decode($response, TRUE);

            if($arr['success']){
                
                $pass_hash = hashPassword($password);
                $token = generateToken();

                $registro = registraUsuario($usuario, $pass_hash, $nombre, $email, $activo, $token, $tipo_usuario);
                
                if($registro > 0){
                    
                    $url = 'http://'.$_SERVER["SERVER_NAME"].'/login/activar.php?id='.$registro.'&val='.$token;

                    $asunto = 'Activar Cuenta - IbtoCoins';
                    $cuerpo = "Estimado $nombre: <br /> <br /> Para continuar con el proceso de registro, es indispensable dar click en el siguiente link <a href='$url'>Activar cuenta</a>";

                    if (enviarEmail($email, $nombre, $asunto, $cuerpo)){

                        echo "Para terminar el registro revise su correo electronico"; 

                        echo "<br><a href='index.php'> Iniciar Sesion</a>";

                        exit;

                    }else{
                        $errors[] = "The email $email dont sent";
                    }

                }else {
                    $errors[] = "Error register";
                }

            }else{
                $errors[] = "Captcha failed";
            }

        }
    }

?>



<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Register - IbotCoins Admin</title>
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    </head>
    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-7">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Create Account</h3></div>
                                    <div class="card-body">
                                        <form id="signupform" role="form" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" autocomplete="off">

                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" name="nombre" type="text" placeholder="Enter your full name" value="<?php if(isset($nombre)) echo $nombre; ?>" required/>
                                                        <label for="nombre">Full name</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-floating">
                                                        <input class="form-control" name="usuario" type="text" placeholder="Enter your user name" value="<?php if(isset($usuario)) echo $usuario; ?>" required  />
                                                        <label for="usuario">User name</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" name="email" type="email" placeholder="name@example.com" value="<?php if(isset($email)) echo $email; ?>" required/>
                                                <label for="email">Email address</label>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" name="password" type="password" placeholder="Create a password" required/>
                                                        <label for="password">Password</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" name="con_password" type="password" placeholder="Confirm password" required />
                                                        <label for="con_password">Confirm Password</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-9">
                                                <div class="g-recaptcha" data-sitekey="6LdEGvIjAAAAAEd5usLNesisNrMb9FiWewp4_K2M"></div>
                                                <input class="form-control d-none" data-recaptcha="true"  data-error="Please complete the Captcha">
                                                <div class="help-block with-errors"></div>
                                            </div>

                                            <div class="mt-4 mb-0">
                                                <div class="d-grid"><button type="submit" class="btn btn-primary btn-block">Create Account</button></div>
                                            </div>
                                        </form>

                                        <?php echo resultBlock($errors);  ?>

                                    </div>
                                    <div class="card-footer text-center py-3">
                                        <div class="small"><a href="index.php">Have an account? Go to login</a></div>
                                    </div>
                                </div>
                                <img src="assets/img/logo.png" alt="">
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2022</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>
