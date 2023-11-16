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
        <h3 class="text-themecolor">Gestionar Empleados</h3>
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
            
            <li class="breadcrumb-item active">Empleados</li>
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
                            <h4>Administrar Empleados</h4>
                        </div>
                    </div>
                </div>
                    <!-- Button trigger modal -->
                    <div class="text-left">
                        <button type="button" class="btn btn-primary mb-2 mr-2" data-toggle="modal" data-target="#formularioregistros">
                            Agregar Empleado
                        </button>
                    </div>
                    <div class="table-responsive mb-4 mt-4" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                            <thead>
                                <th width="1%">ID</th>
                                <th width="9%">Cargo</th>
                                <th width="5%">Tipo Doc</th>
                                <th width="5%">Num Doc</th>
                                <th width="25%">Nombres</th>
                                <th width="5%">Telefono</th>
                                <th width="15%">Direccion</th>
                                <th width="10%">F. Ingreso</th>
                                <th width="5%">Banco</th>
                                <th width="10%">Numero Cuenta</th>
                                <th width="10%">Estado</th>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>


                    <!--  Guardar Modal -->
                    <div class="modal fade" id="formularioregistros" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document" style="width: 200% !important;">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Agregar Empleado</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                                            <line x1="18" y1="6" x2="6" y2="18"></line>
                                            <line x1="6" y1="6" x2="18" y2="18"></line>
                                        </svg>
                                    </button>
                                </div>

                                <div class="modal-body">

                                    <form action="" name="formulario" id="formulario" method="POST" >
                                        
                                    <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Informacion General</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Informacion Financiera</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Informacion Adicional</a>
                                            </li>
                                        </ul>

                                        <div class="tab-content" id="myTabContent">
                                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="border-profile-tab">
                                                <div class="row no-outer-spacing">
                                                    <div class="form-group col-lg-4 col-md-4 col-xs-4">
                                                        <label for="">Cargo</label>
                                                        <select id="idCargo" class="select2 form-control custom-select"  style="width:100%; height:100%;">
                                                        </select>
                                                    </div>


                                                    <div class="form-group col-lg-4 col-md-4 col-xs-4">
                                                        <label for="">Tipo de Documento</label>
                                                        <select id="tipoDocumento" class="form-control"  >
                                                            <option value="DNI">DNI</option>
                                                            <option value="Carne de Extranjeria">Carne de extranjeria</option>
                                                        </select>
                                                    </div>

                                                    <div class="form-group col-lg-4 col-md-4 col-xs-4">
                                                        <label for=""> Numero de Documento</label>
                                                        <input class="form-control" type="hidden" id="idEmpleado" nombre="idEmpleado">
                                                        <input class="form-control" type="number" id="numeroDocumento" nombre="numeroDocumento"  placeholder="Numero de Documento"  min="0" oninput="limitarLongitud(this, 9);validarMinimo(this, 8)" required>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="form-group col-lg-3 col-md-3 col-xs-3">
                                                        <label for="">Apellido Paterno</label>
                                                        <input class="form-control" type="text" id="apellidoPaterno" nombre="apellidoPaterno" maxlength="20" placeholder="Apellido Paterno" oninput="validarTexto(this)" required>
                                                    </div>


                                                    <div class="form-group col-lg-3 col-md-3 col-xs-3">
                                                        <label for="">Apellido Materno</label>
                                                        <input class="form-control" type="text" id="apellidoMaterno" nombre="apellidoMaterno" maxlength="50" placeholder="Apellido Materno" oninput="validarTexto(this)" required>
                                                    </div>

                                                    <div class="form-group col-lg-6 col-md-6 col-xs-6">
                                                        <label for="">Nombres</label>
                                                        <input class="form-control" type="text" id="nombre" nombre="nombre" maxlength="50" placeholder="Nombres" oninput="validarTexto(this)" required>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="form-group col-lg-4 col-md-4 col-xs-4">
                                                        <label for="telefono">Telefono</label>
                                                        <input class="form-control" type="number" id="telefono" nombre="telefono" maxlength="50" placeholder="numero de telefono" min="0" oninput="limitarLongitud(this, 9)" required>
                                                    </div>
                                                    <div class="form-group col-lg-4 col-md-4 col-xs-4">
                                                        <label for="telefono">Persona Contacto</label>
                                                        <input class="form-control" type="text" id="personaContacto" nombre="personaContacto" maxlength="50" placeholder="familiar del contacto" oninput="validarTexto(this)" required>
                                                    </div>
                                                    <div class="form-group col-lg-4 col-md-4 col-xs-4">
                                                        <label for="telefono">Telefono Emergencia</label>
                                                        <input class="form-control" type="text" id="telefonoEmergencia" nombre="telefonoEmergencia" maxlength="50" placeholder="telefono del familiar" min="0" oninput="limitarLongitud(this, 9)" required>
                                                    </div>
                                                </div>
                                            </div>
 <hr>
                                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="border-profile-tab">
                                                <div class="row">
                                                    <div class="form-group col-lg-4 col-md-4 col-xs-4">
                                                        <label for="">Banco</label>
                                                        <select id="idBanco" class="select2 form-control custom-select"  style="width:100%; height:100%;">
                                                        </select>
                                                    </div>


                                                    <div class="form-group col-lg-8 col-md-8 col-xs-8">
                                                        <label for="">Numero de Cuenta</label>
                                                        <input class="form-control" type="number" id="numeroCuenta" nombre="numeroCuenta" maxlength="50" placeholder="numero Cuenta" min="0" oninput="limitarLongitud(this, 20);validarMinimo(this, 20)" required>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-lg-4 col-md-4 col-xs-4">
                                                        <label for="">Tipo de seguro</label>
                                                        <select id="tipoSeguro" class="form-control" >
                                                            <option value="AFP PRIMA">AFP PRIMA</option>
                                                            <option value="AFP INTEGRA">AFP INTEGRA</option>
                                                            <option value="ONP">ONP</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-lg-4 col-md-4 col-xs-4">
                                                        <label for="">Fecha de Seguro de Vida</label>
                                                        <input class="form-control" type="date" id="fechaSeguroVida" nombre="fechaSeguroVida" maxlength="50" required>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="border-profile-tab">
                                                <div class="row">
                                                    <div class="form-group col-lg-4 col-md-4 col-xs-4">
                                                        <label for="">Estado Actual</label>
                                                        <select id="estado" class="select2 form-control custom-select"  style="width: 350px;">
                                                            <option value="Laborando">Laborando</option>
                                                            <option value="De baja">De baja</option>
                                                            <option value="De vacaciones">De vacaciones</option>
                                                            <option value="Renuncia">Renuncia</option>
                                                        </select>
                                                    </div>

                                                    <div class="form-group col-lg-4 col-md-4 col-xs-4">
                                                        <label for="">Fecha de Ingreso</label>
                                                        <input class="form-control" type="date" id="fechaIngreso" nombre="fechaIngreso" maxlength="50" required>
                                                    </div>

                                                    <div class="form-group col-lg-4 col-md-4 col-xs-4">
                                                        <label for="">Fecha de Nacimiento</label>
                                                        <input class="form-control" type="date" id="fechaNacimiento" nombre="fechaNacimiento" maxlength="50" required>
                                                    </div>


                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-lg-5 col-md-5 col-xs-5">
                                                        <label for="">Distrito</label>
                                                        <select id="distrito" class="form-control" >
                                                            <option value=""disabled selected>Escriba o seleccione un distrito</option>
                                                            <option value="ANCON">ANCON</option>
                                                            <option value="ATE">ATE</option>
                                                            <option value="BARRANCO">BARRANCO</option>
                                                            <option value="BREÑA">BREÑA</option>
                                                            <option value="CARABAYLLO">CARABAYLLO</option>
                                                            <option value="CALLAO">CALLAO</option>
                                                            <option value="CHACLACAYO">CHACLACAYO</option>
                                                            <option value="BREÑA">Renuncia</option>
                                                            <option value="CHORRILLOS">CHORRILLOS</option>
                                                            <option value="CIENEGUILLA">CIENEGUILLA</option>
                                                            <option value="COMAS">COMAS</option>
                                                            <option value="EL AGUSTINO">EL AGUSTINO</option>
                                                            <option value="INDEPENDENCIA">INDEPENDENCIA</option>
                                                            <option value="JESUS MARIA">JESUS MARIA</option>
                                                            <option value="LA MOLINA">LA MOLINA</option>
                                                            <option value="LA VICTORIA">LA VICTORIA</option>
                                                            <option value="LIMA">LIMA</option>
                                                            <option value="LIMA PROVINCIAS">LIMA PROVINCIAS</option>
                                                            <option value="LINCE">LINCE</option>
                                                            <option value="LOS OLIVOS">LOS OLIVOS</option>
                                                            <option value="LURIGANCHO">LURIGANCHO</option>
                                                            <option value="LURIN">LURIN</option>
                                                            <option value="MAGDALENA DEL MAR">MAGDALENA DEL MAR</option>
                                                            <option value="MIRAFLORES">MIRAFLORES</option>
                                                            <option value="PACHACAMAC">PACHACAMAC</option>
                                                            <option value="PUCUSANA">PUCUSANA</option>
                                                            <option value="PUEBLO LIBRE">PUEBLO LIBRE</option>
                                                            <option value="PUENTE PIEDRA">PRUENTE PIEDRA</option>
                                                            <option value="PUNTA HERMOSA">PUNTA HERMOSA</option>
                                                            <option value="PUNTA NEGRA">PUNTA NEGRA</option>
                                                            <option value="RIMAC">RIMAC</option>
                                                            <option value="SAN BARTOLO">SAN BARTOLO</option>
                                                            <option value="SAN BORJA">SAN BORJA</option>
                                                            <option value="SAN ISIDRO">SAN ISIDRO</option>
                                                            <option value="SAN JUAN DE LURIGANCHO">SAN JUAN DE LURIGANCHO</option>
                                                            <option value="SAN JUAN DE MIRAFLORES">SAN JUAN DE MIRAFLORES</option>
                                                            <option value="SAN LUIS">SAN LUIS</option>
                                                            <option value="SAN MARTIN DE PORRES">SAN MARTIN DE PORRES</option>
                                                            <option value="SAN MIGUEL">SAN MIGUEL</option>
                                                            <option value="SANTA ANITA">SANTA ANITA</option>
                                                            <option value="SANTA MARIA DEL MAR">SANTA MARIA DEL MAR</option>
                                                            <option value="SANTA ROSA">SANTA ROSA</option>
                                                            <option value="SANTIAGO DE SURCO">SANTIAGO DE SURCO</option>
                                                            <option value="SURQUILLO">SURQUILLO</option>
                                                            <option value="VILLA EL SALVADOR">VILLA EL SALVADOR</option>
                                                            <option value="VILLA MARIA DEL TRIUNFO">VILLA MARIA DEL TRIUNFO</option>
                                                        </select>

                                                    </div>

                                                    <div class="form-group col-lg-7 col-md-7 col-xs-7">
                                                        <label for="direccion">direccion</label>
                                                        <input class="form-control" type="text" id="direccion" nombre="direccion" maxlength="50" placeholder="Direccion">
                                                    </div>

                                                    <div class="form-group col-lg-4 col-md-4 col-xs-4">
                                                        <label for="telefono">Correo Electronico</label>
                                                        <input class="form-control" type="email" id="correo" nombre="correo" maxlength="50" placeholder="example@gmail.com">
                                                    </div>


                                                </div>

                                                <div class="row">
                                                    <div class="form-group col-lg-12 col-md-12 col-xs-12">
                                                        <label for="">Informacion Adicional</label>
                                                        <textarea class="form-control" name="informacionAdicional" id="informacionAdicional" rows="10"></textarea>
                                                    </div>
                                                </div>

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
<?php
}

ob_end_flush();
?>
    <script src="scripts/empleado.js">
    </script>