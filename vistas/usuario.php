<?php
//activamos almacenamiento en el buffer

ob_start();
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.html");
} else {


    require 'layout/header.php';
    require 'layout/navbar.php';
    require 'layout/sidebar.php';
    if ($_SESSION['Escritorio'] == 1) {
?>


        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">Gestionar Usuarios</h3>
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
                    <li class="breadcrumb-item">Usuarios</li>
                    <li class="breadcrumb-item active">Permisos</li>
                </ol>
            </div>
            <div>
                <button class="right-side-toggle waves-effect waves-light btn-inverse btn btn-circle btn-sm pull-right m-l-10"><i class="ti-settings text-white"></i></button>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div id="accordionBasic" class="widget-header">
                            <div class="row">
                                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                    <h4>Administrar Usuarios</h4>
                                </div>
                            </div>
                            <div class="text-left">
                                <button type="button" class="btn btn-primary mb-2 mr-2" data-toggle="modal" data-target="#formularioregistros">
                                    Agregar Usuario
                                </button>
                            </div>

                        </div>
                        <!-- Button trigger modal -->

                        <div class="table-responsive mb-4 mt.4" id="listadoregistros">

                            <table id="tbllistado" class="table table-hover non-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>ID USUARIO</th>
                                        <th>LOGIN</th>
                                        <th>NOMBRES</th>
                                        <th>ESTADO</th>
                                        <th>OPCIONES</th>
                                    </tr>
                                </thead>

                                <tbody>
                                </tbody>

                            </table>
                        </div>

                        <!--  Guardar Modal -->
                        <div class="modal fade " id="formularioregistros" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Agregar Usuario</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                                <line x1="6" y1="6" x2="18" y2="18"></line>
                                            </svg>
                                        </button>
                                    </div>

                                    <div class="modal-body">
                                        <form action="" name="formulario" id="formulario" method="POST">
                                            <div class="row">

                                                <div class="form-group col-lg-12 col-md-12 col-xs-12">
                                                    <label for=""> USUARIO</label>
                                                    <input class="form-control" type="hidden" id="idUsuario" nombre="idUsuario">
                                                    <input class="form-control" type="text" id="login" nombre="login" maxlength="50" placeholder="Nombre del Usuario" required>
                                                </div>
                                                <div class="form-group col-lg-12 col-md-12 col-xs-12">
                                                    <label for=""> PASSWORD</label>
                                                    <input class="form-control" type="password" id="clave" nombre="clave" maxlength="50" placeholder="Nombre del permiso" required>
                                                </div>
                                            </div>
                                                <hr>
                                                <div class="row">
                                                <div class="form-group col-lg-12 col-md-12 col-xs-12">
                                                    <label for=""><b>PERMISOS</b></label>
                                                    <ul id="permisos" style="list-style: none;"></ul>
                                                    <!-- Asegúrate de que tu checkbox esté dentro de la clase bt-switch -->
                                                    
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-primary" id="btnGuardar">Guardar</button>
                                            <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i>Cancelar</button>

                                        </form>
                                    </div>
                                    <div class="modal-footer">

                                    </div>
                                </div>
                            </div>
                        </div>


                        <!--  Actualizar Modal -->
                        <div class="modal fade" id="formularioActualizar" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Actualizar Usuario</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                                <line x1="6" y1="6" x2="18" y2="18"></line>
                                            </svg>
                                        </button>
                                    </div>

                                    <div class="modal-body">
                                        <form action="" name="formActualizar" id="formulario" method="POST">
                                            <div class="row">
                                                <div class="form-group col-lg-12 col-md-12 col-xs-12">
                                                    <label for=""> Permiso</label>
                                                    <input class="form-control" type="hidden" id="idAreaUpdate" nombre="idAreaUpdate">
                                                    <input class="form-control" type="text" id="nombreUpdate" nombre="nombreUpdate" maxlength="50" placeholder="nombre del Permiso" required autofocus>
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-primary actualizar" onclick="Actualizar();">Guardar Cambios</button>
                                            <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i>Cancelar</button>

                                        </form>
                                    </div>


                                    <div class="modal-footer">

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>





    <?php
    } else {
        require 'noacceso.php';
    }
    require 'layout/footer.php';
    ?>
    <script src="scripts/usuario.js"></script>
<?php
}

ob_end_flush();
?>