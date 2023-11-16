<nav class="navbar top-navbar navbar-expand-md navbar-light">
    <!-- ============================================================== -->
    <!-- Logo -->
    <!-- ============================================================== -->
    <div class="navbar-header">
        <a class="navbar-brand" href="escritorio.php">
            <!-- Logo icon --><b>
                <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                <!-- Dark Logo icon -->
                <img src="../app/template/images/iconowes.png" width="50" height="50" alt="homepage" class="dark-logo" />
                <!-- Light Logo icon -->
                <img src="../app/template/images/iconowes.png" alt="homepage" class="light-logo" />
            </b>
            <!--End Logo icon -->
            <!-- Logo text --><span>
                <!-- dark Logo text -->
                <img src="../app/template/images/texto.png" width="150" height="50" alt="homepage" class="dark-logo" />
                <!-- Light Logo text -->
                <img src="../app/template//images/texto.png" class="light-logo" alt="homepage" /></span>
        </a>
    </div>
    <!-- ============================================================== -->
    <!-- End Logo -->
    <!-- ============================================================== -->
    <div class="navbar-collapse">
        <!-- ============================================================== -->
        <!-- toggle and nav items -->
        <!-- ============================================================== -->
        <ul class="navbar-nav mr-auto">
            <!-- This is  -->
            <li class="nav-item"> <a class="nav-link nav-toggler hidden-md-up waves-effect waves-dark" href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
            <li class="nav-item"> <a class="nav-link sidebartoggler hidden-sm-down waves-effect waves-dark" href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
            <li class="nav-item hidden-sm-down"></li>
        </ul>
        <!-- ============================================================== -->
        <!-- User profile and search -->
        <!-- ============================================================== -->

        <ul class="navbar-nav my-lg-0">
            <!-- ============================================================== -->
            <!-- Search -->
            <!-- ============================================================== -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle waves-effect waves-dark" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Bienvenido a WES: <i class="ti-user m-r-5 m-l-5"></i> <?php echo isset($_SESSION['nombreEmpleado']) ? $_SESSION['nombreEmpleado'] : 'Nombre de Usuario'; ?>
                </a>
                <div class="dropdown-menu dropdown-menu-right animated flipInY">
                    <!-- Puedes agregar enlaces para cerrar sesión, cambiar contraseña, etc. -->
                    <a href="login.html" class="dropdown-item">Cerrar Sesión</a>
                </div>
            </li>
            
            <li class="nav-item hidden-xs-down search-box"> <a class="nav-link hidden-sm-down waves-effect waves-dark" href="javascript:void(0)"><i class="ti-search"></i></a>
                <form class="app-search">
                    <input type="text" class="form-control" placeholder="Search & enter"> <a class="srh-btn"><i class="ti-close"></i></a>
                </form>
            </li>
            <!-- ============================================================== -->
            <!-- Comment -->
            <!-- Perfil del Usuario -->
            


            <!-- ============================================================== -->
            <!-- Profile -->
            <!-- ============================================================== -->

        </ul>
    </div>
</nav>
</header>