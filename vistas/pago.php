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
        <h3 class="text-themecolor">Gestionar Pagos</h3>
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
            <li class="breadcrumb-item"><a href="empleado.php">Empleados</a></li>
            <li class="breadcrumb-item active">Pagos</li>
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
                            <h4>Administrar Pagos</h4>
                        </div>
                    </div>
                </div>
                        <!-- Button trigger modal -->
                        <div class="text-left">
                            <button type="button" class="btn btn-primary mb-2 mr-2" data-toggle="modal" data-target="#formularioregistros">
                                Agregar Pago
                            </button>
                        </div>

                        <div class="widget-content widget-content-area">
                            <div class="table-responsive mb-4 mt-4" id="listadoregistros">
                                <table id="tbllistadoPRUEBA" class="table table-striped table-bordered table-condensed table-hover">
                                    <thead>
                                        <th width="10%">DNI</th>
                                        <th width="20%">EMPLEADO</th>
                                        <th width="10%">MES</th>
                                        <th width="10%">AÑO</th>
                                        <th width="10%">TIPO DE REMUNERACION</th>
                                        <th width="10%">REMUNERACION</th>
                                        <th width="10%">BONO</th>
                                        <th width="10%">TOTAL PAGO</th>
                                        <th width="10%">Estado</th>
                                    </thead>
                                    
                                    <tbody>
                                        <TR>
                                        <TD>234563345645</TD>
                                        <TD>PRUEBA1</TD>
                                        <TD>AGOSTO</TD>
                                        <TD>2023</TD>
                                        <TD>MENSUAL</TD>
                                        <TD>1000.00</TD>
                                        <TD>200.00</TD>
                                        <TD>1200.00</TD>
                                        <TD>PAGADO</TD>
                                        </TR>

                                        <TR>
                                        <TD>34543254</TD>
                                        <TD>PRUEBA2</TD>
                                        <TD>AGOSTO</TD>
                                        <TD>2023</TD>
                                        <TD>JORNAL</TD>
                                        <TD>1000.00</TD>
                                        <TD>200.00</TD>
                                        <TD>1200.00</TD>
                                        <TD>PAGADO</TD>
                                        </TR>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>


                        <!--  Guardar Modal -->
                        <div class="modal fade" id="formularioregistros" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Agregar una Orden de Trabajo</h5>
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
                                                <div class="form-group col-lg-6 col-md-6 col-xs-6">
                                                    <label for=""> Empresa</label>
                                                    <select id="idEmpresa" class="form-control selectpicker" data-live-search="true" data-size="20">

                                                    </select>
                                                </div>

                                                <div class="form-group col-lg-6 col-md-6 col-xs-6">
                                                    <label for=""> Almacen</label>
                                                    <select id="idAlmacen" class="form-control selectpicker" data-live-search="true" data-size="20">

                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="form-group col-lg-4 col-md-4 col-xs-4">
                                                    <label for=""> Orden de Trabajo</label>
                                                    <input class="form-control" type="hidden" id="idOT" nombre="idOT">
                                                    <input class="form-control" type="text" id="numero" nombre="numero" maxlength="50" placeholder="# de OT" required>
                                                </div>

                                                <div class="form-group col-lg-8 col-md-8 col-xs-8">
                                                    <label for=""> Descripcion</label>
                                                    <input class="form-control" type="text" id="descripcion" nombre="descripcion" maxlength="50" placeholder="Descripcion" required>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="form-group col-lg-4 col-md-4 col-xs-4">
                                                    <label for=""> Fecha Inicio</label>
                                                    <input class="form-control" type="date" id="fechaInicio" nombre="fechaInicio" maxlength="50" placeholder="Fecha Inicio" required>
                                                </div>

                                                <div class="form-group col-lg-4 col-md-4 col-xs-4">
                                                    <label for=""> Fecha Finalizacion</label>
                                                    <input class="form-control" type="date" id="fechaFin" nombre="fechaFin" maxlength="50" placeholder="Fecha fin" required>
                                                </div>

                                                <div class="form-group col-lg-4 col-md-4 col-xs-4">
                                                    <label for=""> Estado</label>
                                                    <select class="form-control" id="estado">
                                                        <option>POR COMENZAR</option>
                                                        <option>EN EJECUCION</option>
                                                        <option>TERMINADO</option>
                                                        <option>CANCELADO</option>

                                                    </select>
                                                </div>
                                            </div>                                            
                                            <button type="submit" class="btn btn-primary" onclick="guardar();">Guardar</button>
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
                                        <h5 class="modal-title" id="exampleModalLabel">Actualizar Subclase</h5>
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
                                                    <label for=""> Clase</label>
                                                    <select id="idClaseUpdate" class="form-control selectpicker" data-live-search="true" data-size="20">

                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="form-group col-lg-12 col-md-12 col-xs-12">
                                                    <label for=""> Sub Clase</label>
                                                    <input class="form-control" type="hidden" id="idSubclaseUpdate" nombre="idSubclaseUpdate">
                                                    <input class="form-control" type="text" id="nombreUpdate" nombre="nombreUpdate" maxlength="50" placeholder="Nombre de la subclase" required>
                                                </div>
                                            </div>

                                            <button type="submit" class="btn btn-primary actualizar" onclick="Actualizar();">Guardar Cambios</button>
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
    </div>

<?php
  } else {
    require 'noacceso.php';
}
require 'layout/footer.php';
?>
<script src="scripts/ot.js">
</script>
<?php
}

ob_end_flush();
?>