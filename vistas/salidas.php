<?php
require 'layout/header.php';
require 'layout/navbar.php';
require 'layout/sidebar.php';
?>

<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor">Gestionar Salidas</h3>
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
            <li class="breadcrumb-item">Almacén</li>
            <li class="breadcrumb-item active">Salidas</li>
        </ol>
    </div>
    <div>
        <button class="right-side-toggle waves-effect waves-light btn-inverse btn btn-circle btn-sm pull-right m-l-10"><i class="ti-settings text-white"></i></button>
    </div>
</div>

<!-- Botón para abrir el modal de registro -->
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
                <th width="5%">ALMACÉN</th>
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

<!-- Modal de registro -->
<div class="modal fade" id="formularioregistros" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agregar Salida</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form name="formulario" id="formulario" method="POST">
                    <div class="row">
                        <div class="form-group col-lg-4 col-md-4 col-xs-4">
                            <label for="idEmpleado">Empleado</label>
                            <select id="idEmpleado" class="select2 form-control custom-select" style="width:100%; height:100%;">
                                <!-- Opciones para seleccionar un empleado -->
                            </select>
                        </div>
                        <div class="form-group col-lg-4 col-md-4 col-xs-4">
                            <label for="idOT">OT</label>
                            <select id="idOT" class="select2 form-control custom-select" style="width:100%; height:100%;">
                                <!-- Opciones para seleccionar una OT -->
                            </select>
                        </div>
                        <div class="form-group col-lg-4 col-md-4 col-xs-4">
                            <label for="idTipoSalida">Tipo de Salida</label>
                            <select id="idTipoSalida" class="select2 form-control custom-select" style="width:100%; height:100%;">
                                <!-- Opciones para seleccionar un tipo de salida -->
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-lg-12 col-md-12 col-xs-12">
                            <input class="form-control" type="hidden" id="idSalida" name="idSalida">
                            <label for="idExistencia">Existencia</label>
                            <select id="idExistencia" class="select2 form-control custom-select" style="width:100%; height:100%;">
                                <!-- Opciones para seleccionar una existencia -->
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-lg-3 col-md-3 col-xs-3">
                            <label for="fecha">Fecha</label>
                            <input class="form-control" type="date" id="fecha" name="fecha" required>
                        </div>
                        <div class="form-group col-lg-3 col-md-3 col-xs-3">
                            <label for="cantidad">Cantidad:</label>
                            <input class="form-control" type="number" id="cantidad" name="cantidad" required>
                        </div>
                        <div class="form-group col-lg-3 col-md-3 col-xs-3">
                            <label for="costoUnitarioFIFO">Costo Unitario FIFO:</label>
                            <input class="form-control" type="text" id="costoUnitarioFIFO" name="costoUnitarioFIFO" readonly>
                        </div>
                        <div class="form-group col-lg-3 col-md-3 col-xs-3">
                            <label for="subtotal">Subtotal:</label>
                            <input class="form-control" type="text" id="subtotal" name="subtotal" readonly>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i>Guardar</button>
                    <button class="btn btn-danger" data-dismiss="modal"><i class="flaticon-cancel-12"></i>Cancelar</button>
                </form>
            </div>
            <div class="modal-footer">
                <!-- Botones adicionales si es necesario -->
            </div>
        </div>
    </div>
</div>

<?php
require 'layout/footer.php';
?>
<script src="scripts/salidas.js"></script>
