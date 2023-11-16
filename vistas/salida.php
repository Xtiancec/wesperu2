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
        <h3 class="text-themecolor">Gestionar Salidas</h3>
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
            <li class="breadcrumb-item">Almacen</li>
            <li class="breadcrumb-item active">Salidas</li>
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
                            <h4>Administrar Salidas</h4>
                        </div>
                    </div>
                </div>
                <!-- Button trigger modal -->
                <div class="text-left">
                    <button type="button" class="btn btn-primary mb-2 mr-2" data-toggle="modal" data-target="#formularioregistros">
                        Agregar Salida
                    </button>
                </div>


                <div class="widget-content widget-content-area">
                    <div class="table-responsive mb-4 mt-4" id="listadoregistros">


                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                            <thead>
                                <th width="5%">ID</th>
                                <th width="5%">ALMACEN</th>
                                <th width="10%">OT</th>
                                <th width="10%">TIPO SALIDA</th>
                                <th width="5%">FECHA</th>
                                <th width="30%">EXISTENCIA</th>
                                <th width="5%">CANTIDAD</th>
                                <th width="5%">COSTO UNITARIO</th>
                                <th width="10%">SUBTOTAL</th>
                                <th width="15%">EMPLEADO</th>
                                <th width="10%">OPCIONES</th>

                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>


                <!--  Guardar Modal -->
                <div class="modal fade" id="formularioregistros" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" style="max-width: 80%; width: 70%;" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Agregar Salida</h5>
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
                                        <div class="form-group col-lg-4 col-md-4 col-xs-4">
                                            <label for=""> Empleado</label>
                                            <select id="idEmpleado" class="select2 form-control custom-select" style="width:100%; height:100%;">
                                            </select>
                                        </div>

                                        <div class="form-group col-lg-4 col-md-4 col-xs-4">
                                            <label for=""> OT</label>
                                            <select id="idOT" class="select2 form-control custom-select" style="width:100%; height:100%;">
                                            </select>
                                        </div>

                                        <div class="form-group col-lg-4 col-md-4 col-xs-4">
                                            <label for=""> Tipo de Salida</label>
                                            <select id="idTiposalida" class="select2 form-control custom-select" style="width:100%; height:100%;">
                                            </select>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="form-group col-lg-12 col-md-12 col-xs-12">
                                            <input class="form-control" type="hidden" id="idSalida" nombre="idSalida">

                                            <label for=""> Existencia</label>
                                            <select id="idExistencia" class="select2 form-control custom-select" style="width:100%; height:100%;">
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-lg-3 col-md-3 col-xs-3">
                                            <label for=""> Fecha</label>
                                            <input class="form-control" type="date" id="fecha" name="fecha" placeholder="fecha" required>
                                        </div>
                                        <div class="form-group col-lg-3 col-md-3 col-xs-3">
                                            <label for=""> Cantidad</label>
                                            <input class="form-control" type="number" id="cantidad" name="cantidad" min="1" placeholder="Cantidad" required>
                                        </div>
                                        <div class="form-group col-lg-3 col-md-3 col-xs-3">
                                            <label for="">Precio</label>
                                            <input class="form-control" type="number" id="costoUnitario" name="costoUnitario" readonly>
                                        </div>
                                        <div class="form-group col-lg-3 col-md-3 col-xs-3">
                                            <label for=""> Subtotal</label>
                                            <input class="form-control" type="number" id="subTotal" name="subTotal" readonly>
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
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Actualizar Salida</h5>
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
                                        <div class="form-group col-lg-4 col-md-4 col-xs-4">
                                            <label for=""> Empleado</label>
                                            <select id="idEmpleadoUpdate" class="select2 form-control custom-select" style="width:100%; height:100%;">
                                            </select>
                                        </div>

                                        <div class="form-group col-lg-4 col-md-4 col-xs-4">
                                            <label for=""> OT</label>
                                            <select id="idOTUpdate" class="select2 form-control custom-select" style="width:100%; height:100%;">
                                            </select>
                                        </div>

                                        <div class="form-group col-lg-4 col-md-4 col-xs-4">
                                            <label for=""> Tipo de Salida</label>
                                            <select id="idTiposalidaUpdate" class="select2 form-control custom-select" style="width:100%; height:100%;">
                                            </select>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="form-group col-lg-12 col-md-12 col-xs-12">
                                            <input class="form-control" type="hidden" id="idSalidaUpdate" nombre="idSalidaUpdate">

                                            <label for=""> Existencia</label>
                                            <select id="idExistenciaUpdate" class="select2 form-control custom-select" style="width:100%; height:100%;">
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-lg-3 col-md-3 col-xs-3">
                                            <label for=""> Fecha</label>
                                            <input class="form-control" type="date" id="fechaUpdate" nombre="fechaUpdate" placeholder="fecha" required>
                                        </div>
                                        <div class="form-group col-lg-3 col-md-3 col-xs-3">
                                            <label for=""> Cantidad</label>
                                            <input class="form-control" type="number" id="cantidadUpdate" nombre="cantidadUpdate" min="1" placeholder="Cantidad" required>
                                        </div>
                                        <div class="form-group col-lg-3 col-md-3 col-xs-3">
                                            <label for=""> Precio</label>
                                            <input class="form-control" type="number" id="costoUnitarioUpdate" nombre="costoUnitarioUpdate" min="0" step="0.01" placeholder="S/0.00" required>
                                        </div>
                                        <div class="form-group col-lg-3 col-md-3 col-xs-3">
                                            <label for=""> Subtotal</label>
                                            <input class="form-control" type="text" id="subTotalUpdate" nombre="subTotalUpdate" placeholder="S/0.00" disabled>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary" onclick="Actualizar();"><i class="fa fa-check"></i>Guardar Cambios</button>
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

<?php
} else {
    require 'noacceso.php';
}

require 'layout/footer.php';
?>
<script src="scripts/salida.js">
</script>
<?php
}

ob_end_flush();
?>