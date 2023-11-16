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
        <h3 class="text-themecolor">Gestionar Comprobantes</h3>
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
            <li class="breadcrumb-item"><a href="ingreso.php">Almacen</a></li>
            <li class="breadcrumb-item active">Comprobantes</li>
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
                <div class="box-header with-border">
                    <h2 ><b>COMPROBANTE</b> </h2><button class="btn btn-success" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
                    <div class="box-tools pull-right">
                    </div>
                </div>
                <div class="panel-body table-responsive" id="listadoregistros">
                    <table id="tbllistado" class="table table-bordered table-condensed table-hover" >
                        <thead style="background-color: #000000; color: white;">
                            <th style="width: 10%;">FECHA</th>
                            <th style="width: 30%;">CLIENTE</th>
                            <th style="width: 10%;">TIPO COMPROBANTE</th>
                            <th style="width: 10%;">ALMACEN</th>
                            <th style="width: 10%;">TIPO INGRESO</th>
                            <th style="width: 10%;">TOTAL</th>
                            <th style="width: 10%;">NUMERO COMPROBANTE</th>
                            <th style="width: 5%;">ESTADO</th>
                            <th style="width: 5%;">OPCIONES</th>
                        </thead>

                        <tbody>
                            <!-- Aquí van los datos de la tabla -->
                        </tbody>
                    </table>
                </div>

                <div class="col-md-12">
                    <div class="card card-body printableArea">

                    <div class="panel-body" id="formularioregistros">
                    <form action="" name="formulario" id="formulario" method="POST">
                        <div class="row">
                            <div class="form-group col-lg-6 col-md-6 col-xs-12">
                                <label for=""><b>Cliente(*):</b></label>                                
                                <select name="idEmpresa" id="idEmpresa" class="select2 form-control custom-select" style="width:100%; height:100%;" required>
                                </select>
                            </div>

                            <div class="form-group col-lg-3 col-md-3 col-xs-12">
                                <label for=""><b>TIPO DE COMPROBANTE(*):</b></label>
                                <select name="idTipocomprobante" id="idTipocomprobante" class="select2 form-control custom-select" style="width:100%; height:100%;" required>
                                </select>
                            </div>
                            <div class="form-group col-lg-3 col-md-3 col-xs-12">
                                <label for=""><b>TIPO DE INGRESO(*):</b></label>
                                <select name="idTipoingreso" id="idTipoingreso" class="select2 form-control custom-select" style="width:100%; height:100%;" required>
                                </select>
                            </div>


                        </div>
                  
                        <div class="row">


                            <div class="form-group col-lg-5 col-md-5 col-xs-12">
                                <label for=""><b>Numero: </b></label>
                                <input class="form-control" type="text" name="numero" id="numero" maxlength="7" placeholder="Numero de Comprobante" required>
                                <input class="form-control" type="hidden" name="idComprobante" id="idComprobante">
                            </div>

                            <div class="form-group col-lg-4 col-md-4 col-xs-12">
                                <label for=""><b>ALMACEN(*):</b></label>
                                <select name="idAlmacen" id="idAlmacen" class="select2 form-control custom-select" style="width:100%; height:100%;" required>
                                </select>
                            </div>

                            <div class="form-group col-lg-3 col-md-3 col-xs-12">
                                <label for=""><b>Fecha(*): </b></label>
                                <input class="form-control" type="date" name="fecha" id="fecha" required>
                            </div>

                        </div>
                        <hr>
                        <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <a data-toggle="modal" href="#myModal">
                                <button id="btnAgregarArt" type="button" class="btn btn-primary"><span class="fa fa-plus"></span> Agregar Existencia</button>
                            </a>
                        </div>

                        <div class="form-group col-lg-12 col-md-12 col-xs-12">
                            <table id="detalles"  class="table table-bordered table-hover" style="min-width: 600px; overflow-y: auto;">
                                <thead style="background-color: #191970; color: white;">
                                    <th class="text-center" style="width: 10%;"><b>ITEM</b></th>
                                    <th class="text-center" style="width: 10%;"><b>Eliminar</b></th>
                                    <th class="text-center" style="width: 50%;"><b>Existencia</b></th>
                                    <th class="text-center" style="width: 5%;"><b>Cantidad</b></th>
                                    <th class="text-center" style="width: 5%;"><b>Precio</b></th>
                                    <th class="text-center" style="width: 10%;"><b>Subtotal</b></th>
                                    <th class="text-center" style="width: 10%;"><b>Opciones</b></th>
                                </thead>

                                <tfoot>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th><b>TOTAL:</b></th>
                                    <th class="text-right">
                                        <h4 id="total"><b>S/. 0.00</b></h4><input type="hidden" name="precioTotal" id="precioTotal">
                                    </th>

                                </tfoot>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                        <div class="clearfix"></div>
                        <hr>
                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>
                            <button class="btn btn-danger" onclick="cancelarform()" type="button" id="btnCancelar"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                            <button id="print" class="btn btn-default btn-outline" type="button"> <span><i class="fa fa-print"></i> Imprimir</span> </button>

                        </div>

                    </form>
                </div>

                    </div>
                </div>


                

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="max-width: 80%; width: 70%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agregar Existencia al Comprobante</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="tblexistencias" class="table table-bordered table-condensed table-hover table-sm" style="width: 100%;">
                                        <thead  style="background-color: #2F4F4F; color: white;">
                                            <tr>
                                                <th style="width: 10%;"><b>Opciones</b></th>
                                                <th class="text-center" style="width: 10%;"><b>Clase</b></th>
                                                <th class="text-center" style="width: 10%;"><b>SubClase</b></th>
                                                <th style="width: 50%;"><b>Existencia</b></th>
                                                <th style="width: 10%;"><b>Stock</b></th>
                                                <th style="width: 10%;"><b>U.M.</b></th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <!-- Aquí puedes agregar filas de datos si es necesario -->
                                        </tbody>
                                    </table>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-default" type="button" data-dismiss="modal">Cerrar</button>
                                </div>
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
<script src="scripts/comprobante.js">
</script>
<?php
}

ob_end_flush();
?>