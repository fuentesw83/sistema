<?php
    session_start();
    require "conection.php"; 
    require "funcs.php"; 
    

    $errors = array();

    if(!empty($_POST)){

        $usuario = $mysqli->real_escape_string($_POST['usuario']);
        $password = $mysqli->real_escape_string($_POST['password']);

        if(isNullLogin($usuario, $password)){
            $errors = "Fill all fields";
        }

        $errors[] = login($usuario, $password);
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
        <title>Login - IbotCoins </title>
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
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Login</h3></div>
                                    <div class="card-body">
                                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" autocomplete="off">
                                            <div class="form-floating mb-3">
                                                <input class="form-control"  id="usuario" name="usuario" type="text" placeholder="User" required/>
                                                <label for="usuario">User or Email</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="password" name="password" type="password" placeholder="Password" required/>
                                                <label for="password">Password</label>
                                            </div>
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" id="inputRememberPassword" type="checkbox" value="" />
                                                <label class="form-check-label" for="inputRememberPassword">Remember Password</label>
                                            </div>

                                            <!-- <div class="mb-3">
                                                <div class="g-recaptcha" data-sitekey="6LdEGvIjAAAAAEd5usLNesisNrMb9FiWewp4_K2M"></div>
                                                <input class="form-control d-none" data-recaptcha="true" required data-error="Please complete the Captcha">
                                                <div class="help-block with-errors"></div>
                                            </div> -->

                                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <a class="small" href="password.html">Forgot Password?</a>
                                                <button id="btn-login" type="submit" class="btn btn-primary">Login</button>
                                            </div>
                                        </form>

                                        <?php echo resultBlock($errors);  ?>

                                    </div>
                                    <div class="card-footer text-center py-3">
                                        <div class="small"><a href="register.php">Need an account? Sign up!</a></div>
                                    </div>
                                </div>
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