<?php
//activamos almacenamiento en el buffer
require 'layout/header.php';
require 'layout/navbar.php';
require 'layout/sidebar.php';
?>

<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor">Gestionar Proveedores</h3>
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
            <li class="breadcrumb-item">Almacen</li>
            <li class="breadcrumb-item active">Proveedores</li>
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
                            <h4>Administrar Proveedores</h4>
                        </div>
                    </div>
                </div>
                        <!-- Button trigger modal -->
                        <div class="text-left">
                            <button type="button" class="btn btn-primary mb-2 mr-2" data-toggle="modal" data-target="#formularioregistros">
                                Agregar Empresa
                            </button>
                        </div>
                        <div class="widget-content widget-content-area">
                            <div class="table-responsive mb-4 mt-4" id="listadoregistros">
                                <table id="tbllistadoProveedores" class="table table-striped table-bordered table-condensed table-hover">
                                    <thead>
                                        <th width="5%">ID</th>
                                        <th width="10%">TIPO EMPRESA</th>
                                        <th width="10%">RUC</th>
                                        <th width="30%">EMPRESA</th>
                                        <th width="10%">TELEFONO</th>
                                        <th width="5%">BANCO</th>
                                        <th width="10%">N° CUENTA</th>
                                        <th width="10%">ESTADO</th>
                                        <th width="10%">OPCIONES</th>
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
                                        <h5 class="modal-title" id="exampleModalLabel">Agregar una empresa</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                                <line x1="6" y1="6" x2="18" y2="18"></line>
                                            </svg>
                                        </button>
                                    </div>

                                    <div class="modal-body">
                                        <form action="" name="formulario" id="formulario" method="POST">
                                            <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Informacion General</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Informacion Adicional</a>
                                                </li>

                                            </ul>

                                            <div class="tab-content" id="myTabContent">
                                                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                                    <div class="row">
                                                        <div class="form-group col-lg-3 col-md-3 col-xs-3">
                                                            <label for="">tipo Empresa</label>
                                                            <select id="tipoEmpresa" class="select2 form-control custom-select"  style="width:100%; ">
                                                                <option title="Proveedor">Proveedor</option>
                                                                <option title="Cliente">Cliente</option>
                                                            </select>
                                                        </div>

                                                        <div class="form-group col-lg-5 col-md-5 col-xs-5">
                                                            <label for=""> RUC</label>
                                                            <input class="form-control" type="hidden" id="idEmpresa" nombre="idEmpresa">
                                                            <input class="form-control" type="number" id="RUC" nombre="RUC" maxlength="11" placeholder="INGRESE EL RUC" required>
                                                            <input class="form-control" type="hidden" id="numeroDocumento" nombre="numeroDocumento" required>

                                                        </div>

                                                   

                                                        <div class="form-group col-lg-4 col-md-4 col-xs-4">
                                                            <label for=""> Telefono</label>
                                                            <input class="form-control" type="number" id="telefono" nombre="telefono" maxlength="10" placeholder="ingrese el numero de telefono">
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="form-group col-lg-12 col-md-12 col-xs-12">
                                                            <label for=""> Nombre de la empresa</label>
                                                            <input class="form-control" type="text" id="nombre" nombre="nombre" maxlength="100" placeholder="Nombre de la empresa">
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="form-group col-lg-12 col-md-12 col-xs-12">
                                                            <label for=""> Direccion</label>
                                                            <input class="form-control" type="text" id="direccion" nombre="direccion" maxlength="100" placeholder="Direccion de la empresa">
                                                        </div>

                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group col-lg-4 col-md-4 col-xs-4">
                                                            <label for=""> Departamento</label>
                                                            <input class="form-control" type="text" id="departamento" nombre="departamento" maxlength="100" placeholder="departamento">
                                                        </div>
                                                        <div class="form-group col-lg-4 col-md-4 col-xs-4">
                                                            <label for=""> Provincia</label>
                                                            <input class="form-control" type="text" id="provincia" nombre="provincia" maxlength="100" placeholder="provincia">
                                                        </div>
                                                        <div class="form-group col-lg-4 col-md-4 col-xs-4">
                                                            <label for=""> Distrito</label>
                                                            <input class="form-control" type="text" id="distrito" nombre="distrito" maxlength="100" placeholder="distrito">
                                                        </div>

                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group col-lg-6 col-md-6 col-xs-6">
                                                            <label for=""> Estado</label>
                                                            <input class="form-control" type="text" id="estados" nombre="estado" maxlength="100" placeholder="estados">
                                                        </div>
                                                        <div class="form-group col-lg-6 col-md-6 col-xs-6">
                                                            <label for=""> Condicion</label>
                                                            <input class="form-control" type="text" id="condicion" nombre="condicion" maxlength="100" placeholder="condicion">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                                    <div class="row">
                                                        <div class="form-group col-lg-4 col-md-4 col-xs-4">
                                                            <label for="">Banco</label>
                                                            <select id="idBanco" class="select2 form-control custom-select"  style="width:100%;">
                                                            </select>
                                                        </div>

                                                        <div class="form-group col-lg-8 col-md-8 col-xs-8">
                                                            <label for="">Numero de Cuenta</label>
                                                            <input class="form-control" type="number" id="numeroCuenta" nombre="numeroCuenta"  placeholder="Numero de cuenta">
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="form-group col-lg-12 col-md-12 col-xs-12">
                                                            <label for="">Informacion General</label>
                                                            <textarea class="form-control" name="informacionGeneral" id="informacionGeneral" rows="10"></textarea>
                                                        </div>
                                                    </div>
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
                    </div>
                </div>
            </div>
        </div>
  


<?php
require 'layout/footer.php';
?>
<script src="scripts/empresa.js">
</script>
<?php
?>


<script>
    $(document).ready(function() {
	$("#RUC").on("input", function() {
		var ruc = $(this).val();
		if (ruc.length !== 11) {
			return;
		}
		$.ajax({
			url: "api.php",
			data: 'ruc=' + ruc,
			dataType: "json",
			success: function(data) {
				console.log(data);
				$("#nombre").val(data.nombre);
				$("#direccion").val(data.direccion);
				$("#estados").val(data.estado);
				$("#condicion").val(data.condicion);
				$("#departamento").val(data.departamento);
				$("#provincia").val(data.provincia);
				$("#distrito").val(data.distrito);
			},
			error: function() {
				console.error("error al realizar solicitud");
			}
		});

	})
});
</script>