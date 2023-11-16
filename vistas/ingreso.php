<?php
//activamos almacenamiento en el buffer



require 'layout/header.php';
require 'layout/navbar.php';
require 'layout/sidebar.php';
?>

<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor">Gestionar Ingresos</h3>
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
            <li class="breadcrumb-item">Almacen</li>
            <li class="breadcrumb-item active">Ingreso</li>
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
                            <h4>Administrar Ingresos</h4>
                        </div>
                    </div>
                </div>
                <!-- Button trigger modal -->
                <!--<div class="text-left">
                    <button type="button" class="btn btn-primary mb-2 mr-2" data-toggle="modal" data-target="#formularioregistros">
                        Agregar Ingreso
                    </button>
                </div>-->


                <div class="widget-content widget-content-area">
                    <div class="table-responsive mb-4 mt-4" id="listadoregistros">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>Fecha Inicio</td>
                                    <td><input type="date" id="min" class="form-control" name="min"></td>

                                    <td>Fecha Fin</td>
                                    <td><input type="date" id="max" class="form-control" name="max"></td>
                                </tr>
                            </tbody>
                        </table>

                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                            <thead>
                                <th width="5%">ID</th>
                                <th width="10%">FECHA INGRESO</th>
                                <th width="10%">COMPROBANTE</th>
                                <th width="30%">EXISTENCIA</th>
                                <th width="5%">PRECIO</th>
                                <th width="10%">CANT.</th>
                                <th width="10%">UM</th>
                                <th width="10%">SUBTOTAL</th>
                                <th width="10%">FECHA ACT.</th>

                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>


                <!--  Guardar Modal -->
                <div class="modal fade" id="formularioregistros" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Agregar Ingreso</h5>
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
                                            <label for=""> Almacen</label>
                                            <select id="idAlmacen" class="select2 form-control custom-select" style="width:100%; height:100%;">
                                            </select>
                                        </div>

                                        <div class="form-group col-lg-4 col-md-4 col-xs-4">
                                            <label for=""> Comprobante</label>
                                            <select id="idComprobante" class="select2 form-control custom-select" style="width:100%; height:100%;">
                                            </select>
                                        </div>

                                        <div class="form-group col-lg-4 col-md-4 col-xs-4">
                                            <label for=""> Tipo de Ingreso</label>
                                            <select id="idTipoingreso" class="select2 form-control custom-select" style="width:100%; height:100%;">
                                            </select>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="form-group col-lg-12 col-md-12 col-xs-12">
                                            <input class="form-control" type="hidden" id="idIngreso" nombre="idIngreso">

                                            <label for=""> Existencia</label>
                                            <select id="idExistencia" class="select2 form-control custom-select" style="width:100%; height:100%;">
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row">

                                        <div class="form-group col-lg-4 col-md-4 col-xs-4">
                                            <label for=""> Cantidad</label>
                                            <input class="form-control" type="number" id="cantidad" nombre="cantidad" min="1" placeholder="Cantidad" required>
                                        </div>
                                        <div class="form-group col-lg-4 col-md-4 col-xs-4">
                                            <label for=""> Precio</label>
                                            <input class="form-control" type="number" id="precio" nombre="precio" min="0" step="0.01" placeholder="S/0.00" required>
                                        </div>
                                        <div class="form-group col-lg-4 col-md-4 col-xs-4">
                                            <label for=""> Subtotal</label>
                                            <input class="form-control" type="text" id="subtotal" nombre="subtotal" placeholder="S/0.00" disabled>
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
                    <div class="modal-dialog modal-xl" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Actualizar Ingreso</h5>
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
                                        <div class="form-group col-lg-4 col-md-4 col-xs-4">
                                            <label for=""> Almacen</label>
                                            <select id="idAlmacenUpdate" class="select2 form-control custom-select" style="width:100%; height:100%;">
                                            </select>
                                        </div>

                                        <div class="form-group col-lg-4 col-md-4 col-xs-4">
                                            <label for=""> Comprobante</label>
                                            <select id="idComprobanteUpdate" class="select2 form-control custom-select" style="width:100%; height:100%;">
                                            </select>
                                        </div>

                                        <div class="form-group col-lg-4 col-md-4 col-xs-4">
                                            <label for=""> Tipo de Ingreso</label>
                                            <select id="idTipoingresoUpdate" class="select2 form-control custom-select" style="width:100%; height:100%;">
                                            </select>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="form-group col-lg-12 col-md-12 col-xs-12">
                                            <input class="form-control" type="hidden" id="idIngresoUpdate" nombre="idIngresoUpdate">

                                            <label for=""> Existencia</label>
                                            <select id="idExistenciaUpdate" class="select2 form-control custom-select" style="width:100%; height:100%;">
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row">

                                        <div class="form-group col-lg-4 col-md-4 col-xs-4">
                                            <label for=""> Cantidad</label>
                                            <input class="form-control" type="number" id="cantidadUpdate" nombre="cantidadUpdate" min="1" placeholder="Cantidad" required>
                                        </div>
                                        <div class="form-group col-lg-4 col-md-4 col-xs-4">
                                            <label for=""> Precio</label>
                                            <input class="form-control" type="number" id="precioUpdate" nombre="precioUpdate" step="0.01" placeholder="Precio" required>
                                        </div>
                                        <div class="form-group col-lg-4 col-md-4 col-xs-4">
                                            <label for=""> Subtotal</label>
                                            <input class="form-control" type="number" id="subtotalUpdate" nombre="subtotalUpdate" maxlength="50" placeholder="Total" disabled>
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
require 'layout/footer.php';
?>
<script src="scripts/ingreso.js">
</script>
<?php
?>