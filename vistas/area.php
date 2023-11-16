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
        <h3 class="text-themecolor">Gestionar Areas</h3>
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb ">
            <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
            <li class="breadcrumb-item">Configuracion</li>
            <li class="breadcrumb-item active">Area</li>
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
                        <div class="ribbon-wrapper col-xl-12 col-md-12 col-sm-12 col-12">
                            <div class="ribbon ribbon-bookmark ribbon-success">Administrar Areas</div>
                        </div>
                    </div>
                    <div class="text-left">
                        <button type="button" class="btn btn-primary mb-2 mr-2" data-toggle="modal" data-target="#formularioregistros">
                            Agregar Area
                        </button>
                    </div>

                </div>
                <!-- Button trigger modal -->

                <div class="table-responsive mb-4 mt-4">
                    <table id="tbllistado" class="table table-hover non-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th width="10%">ID</th>
                                <th width="30%">Nombre</th>
                                <th width="15%">F. Creacion</th>
                                <th width="15%">F. Actualizacion</th>
                                <th width="15%">Estado</th>
                                <th width="15%">Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>

                <!--  Guardar Modal -->
                <div class="modal fade" id="formularioregistros" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Agregar Area</h5>
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
                                            <label for=""> Area</label>
                                            <input class="form-control" type="hidden" id="idArea" nombre="idArea">
                                            <input class="form-control" type="text" id="nombre" nombre="nombre" maxlength="50" placeholder="Nombre del area" required>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary" onclick="guardar();"><i class="fa fa-check"></i>Guardar</button>
                                    <button class="btn btn-danger" data-dismiss="modal"><i class="flaticon-cancel-12"></i>Cancelar</button>

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
                                <h5 class="modal-title" id="exampleModalLabel">Actualizar Clase</h5>
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
                                            <label for=""> Area</label>
                                            <input class="form-control" type="hidden" id="idAreaUpdate" nombre="idAreaUpdate">
                                            <input class="form-control" type="text" id="nombreUpdate" nombre="nombreUpdate" maxlength="50" placeholder="Nombre del area" required autofocus>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary actualizar" onclick="Actualizar();"><i class="fa fa-check"></i>Guardar Cambios</button>
                                    <button class="btn btn-danger" data-dismiss="modal"><i class="flaticon-cancel-12"></i>Cancelar</button>

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






<!-- /.box -->


<!-- /.content -->

<?php
    } else {
        require 'noacceso.php';
    }

require 'layout/footer.php';
?>
<script src="scripts/area.js"></script>
<?php
}

ob_end_flush();
?>