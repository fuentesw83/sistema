<?php

    session_start();    
    require 'conection.php';
    require 'funcs.php';
    require 'models/planes.models.php';
    
    $data = new Data();
   

    if(!isset($_SESSION['id_usuario'])){

        header("Location: index.php");

    }

    $nombre = $_SESSION['nombre'];
    @$tipo_usuario = $_SESSION['tipo_usuario'];

?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="IbotCoins Admin Dashboard" />
        <meta name="author" content="Alfonso Fuentes" />
        <title>Dashboard - IbotCoins</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="index.html">IbotCoins FS</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <!-- <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
                <div class="input-group">
                    <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
                    <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
                </div>
            </form> -->
            <!-- Navbar-->
            <ul class="navbar-nav ms-auto me-0 me-md-3 my-2 my-md-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><?php echo $nombre;?><i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#!">Settings</a></li>
                        <!-- <li><a class="dropdown-item" href="#!">Activity Log</a></li> -->
                        <li><hr class="dropdown-divider" /></li>
                        <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <!-- <div class="sb-sidenav-menu-heading">Settings</div> -->
                            <a class="nav-link" href="index.html">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Admin Panel
                            </a>

                            <?php if($tipo_usuario == 1) { ?>

                            <div class="sb-sidenav-menu-heading">Interface</div>
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                Inversiones
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="https://botuser.ibotcoinsfs.com/">Ibot</a>
                                    <a class="nav-link" href="layout-sidenav-light.html">Light Sidenav</a>
                                </nav>
                            </div>
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
                                <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                                Pages
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth">
                                        Authentication
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            <a class="nav-link" href="login.html">Login</a>
                                            <a class="nav-link" href="register.html">Register</a>
                                            <a class="nav-link" href="password.html">Forgot Password</a>
                                        </nav>
                                    </div>
                                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseError" aria-expanded="false" aria-controls="pagesCollapseError">
                                        Error
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            <a class="nav-link" href="401.html">401 Page</a>
                                            <a class="nav-link" href="404.html">404 Page</a>
                                            <a class="nav-link" href="500.html">500 Page</a>
                                        </nav>
                                    </div>
                                </nav>
                            </div>

                            <?php } ?>
                            

                            
                            
                            <a class="nav-link" href="planes.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                                Planes
                            </a>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in:</div>
                        IbotCoins Dashboard
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12">
                                <h4>Planes</h4>
                                <legend>WALLET TOTAL: $ <strong>
                                    <?php 
                                        echo number_format($data->infoWallet($_SESSION['id_usuario']));
                                    ?>
                                    </strong>
                                </legend>
                            </div>
                            <?php 
                            foreach($data->infoPlanes() as $plan){
                            ?>
                            <div class="col-sm-4">
                                <div class="card" style="width: 18rem; background-color: black;">
                                    <center>
                                    <div class="card-body" style="color: white;">
                                        <h5 class="card-title">Invest from <?php echo $plan['NOMBRE']; ?></h5>
                                        <p class="card-text">Investment Time <?php echo $plan['VALORMINIMO']." - ".$plan['VALORMAXIMO']; ?></p>
                                        <p class="card-text">Daily Interests <?php echo $plan['PORCENTAJEDIA']?></p>
                                        
                                    </div>
                                    </center>
                                    <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                        ADQUIRIR
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="staticBackdropLabel">ADQUIRIR PLAN</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <h5 class="card-title">Invest from <?php echo $plan['NOMBRE']; ?></h5>
                                                <p class="card-text">Investment Time <?php echo $plan['VALORMINIMO']." - ".$plan['VALORMAXIMO']; ?></p>
                                                <p class="card-text">Daily Interests <?php echo $plan['PORCENTAJEDIA']?></p>
                                                <div id="celdaCodigo">
                                                    <img src="assets/img/USDT.png" alt="">
                                                </div>  
                                                <form action="models/add.php" method="post">
                                                    <label for="">
                                                        <legend>Pay:</legend> <br>
                                                        <input id="USDT" type="radio" name="paga" value="USDT">USDT <BR>
                                                        <input id="BTC" type="radio" name="paga" value="BTC">BTC <br>
                                                        <input id="ETH" type="radio" name="paga" value="ETH">ETH <br>
                                                        <script>
                                                            document.getElementById('USDT').addEventListener('click', function(){ document.getElementById('celdaCodigo').innerHTML = "<legend>WALLET USDT</legend><p>TSzux6yyuJuFLAwdGp9KDjTV48WbCHGenJ</p><img src='assets/img/USDT.png'>"; });
                                                            document.getElementById('BTC').addEventListener('click', function(){ document.getElementById('celdaCodigo').innerHTML = "<legend>WALLET BTC</legend><p>1PqBGxwU5DyJ6DfAHnTEaDwzqHGqhX9ekb</p><img src='assets/img/BTC.png'>"; });
                                                            document.getElementById('ETH').addEventListener('click', function(){ document.getElementById('celdaCodigo').innerHTML = "<legend>WALLET ETH</legend><p>0xe13ea0a285dcf0f84c5c23f65e10d19d19ff2bcf</p><img src='assets/img/ETH.png'>"; });
                                                        </script>
                                                    </label>
                                                    <br><br>
                                                    <input type="number" name="valor" class="form-control" placeholder="VALOR" min="<?php echo $plan['VALORMINIMO']; ?>" max="<?php echo $plan['VALORMAXIMO']; ?>">
                                                    <input type="hidden" name="planid" value="<?php echo $plan['PLANID']; ?>">
                                                    <input type="hidden" name="usuarioid" value="<?php echo $_SESSION['id_usuario']; ?>">
                                                    <input type="hidden" name="ACCION" value="addPlanxUsuario">
                                                    <br>
                                                    <input type="submit" class="btn btn-success" value="Save">
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                              
                                            </div>
                                            </div>
                                        </div>
                                        </div>
                                </div>
                            </div>
                        
                            <?php } ?>
                        </div>
                    </div>
                </main>
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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
    </body>
</html>
