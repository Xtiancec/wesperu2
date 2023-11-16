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
        <h3 class="text-themecolor">Gestionar Unidad de Medida</h3>
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
            <li class="breadcrumb-item">Paginas</li>
            <li class="breadcrumb-item active">Unidad de Medida</li>
        </ol>
    </div>
    <div>
        <button class="right-side-toggle waves-effect waves-light btn-inverse btn btn-circle btn-sm pull-right m-l-10"><i class="ti-settings text-white"></i></button>
    </div>
</div>
<!-- ============================================================== -->
<!-- End Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->

<!-- ============================================================== -->
<!-- Start Page Content -->
<!-- ============================================================== -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                
                <div id="accordionBasic" class="widget-header">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <h4>Administrar Unidad de Medida</h4>
                        </div>
                    </div>
                </div>
                        <!-- Button trigger modal -->
                        <div class="text-left">
                            <button type="button" class="btn btn-primary mb-2 mr-2" data-toggle="modal" data-target="#formularioregistros">
                                Agregar Unidad de Medida
                            </button>
                        </div>

                        <div class="table-responsive mb-4 mt-4" id="listadoregistros">
                            <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                                <thead>
                                    <th width="10%">ID</th>
                                    <th width="20%">Nombre</th>
                                    <th width="50%">Descripcion</th>
                                    <th width="10%">Estado</th>
                                    <th width="10%">Opciones</th>
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
                                        <h5 class="modal-title" id="exampleModalLabel">Agregar Unidad de Medida</h5>
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
                                                    <label for=""> Unidad de Medida</label>
                                                    <input class="form-control" type="hidden" id="idUM" nombre="idUM">
                                                    <input class="form-control" type="text" id="nombre" nombre="nombre" maxlength="50" placeholder="Nombre de la Unidad de Medida" required>
                                                </div>
                                            </div>



                                            <div class="form-group col-lg-12 col-md-12 col-xs-12">
                                                <label for=""> Descripcion</label>

                                                <input class="form-control" type="text" id="descripcion" nombre="descripcion" maxlength="50" placeholder="Descripcion de la Unidad de Medida" required>
                                            </div>

                                            <button type="submit" class="btn btn-primary"onclick="guardar();"><i class="fa fa-check"></i>Guardar</button>
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
                                        <h5 class="modal-title" id="exampleModalLabel">Actualizar Unidad de Medida</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                                <line x1="6" y1="6" x2="18" y2="18"></line>
                                            </svg>
                                        </button>
                                    </div>

                                    <div class="modal-body">
                                        <form action="" name="formActualizar" id="formActualizar" method="POST">
                                        <div class="row">
                                                <div class="form-group col-lg-12 col-md-12 col-xs-12">
                                                    <label for=""> Unidad de Medida</label>
                                                    <input class="form-control" type="hidden" id="idUMUpdate" nombre="idUMUpdate">
                                                    <input class="form-control" type="text" id="nombreUpdate" nombre="nombreUpdate" maxlength="50" placeholder="Nombre de la Unidad de Medida" required>
                                                </div>
                                            </div>



                                            <div class="form-group col-lg-12 col-md-12 col-xs-12">
                                                <label for=""> Descripcion</label>

                                                <input class="form-control" type="text" id="descripcionUpdate" nombre="descripcionUpdate" maxlength="50" placeholder="Descripcion de la Unidad de Medida" required>
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

<script src="scripts/um.js">

</script>




<?php
}

ob_end_flush();
?>