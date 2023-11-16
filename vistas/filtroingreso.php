<?php
//activamos almacenamiento en el buffer



require 'layout/header.php';
require 'layout/navbar.php';
require 'layout/sidebar.php';
?>

<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor">Filtros de Ingreso</h3>
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
            <li class="breadcrumb-item">Paginas</li>
            <li class="breadcrumb-item active">Almacen</li>
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
                            <h4>Filtros</h4>
                        </div>
                    </div>
                </div>
                            <div class="table-responsive mb-4 mt-4" id="listadoregistros">
                                <table class="table">
                                    <tbody>
                                        <div class="row">
                                            <div class="form-group col-lg-6 col-md-6 col-xs-6">
                                                
                                                    <label for="" class="text-info">Minimo SubTotal:</label>
                                                    <input type="number"  id="min" class="form-control" name="min">

                                            </div>

                                            <div class="form-group col-lg-6 col-md-6 col-xs-6">
                                                
                                                    <label class="text-info">Maximo Subtotal:</label>
                                                    <input type="number" id="max" class="form-control" name="max">
                                               
                                            </div>

                                        </div>
                                    </tbody>
                                </table>

                                <table id="tbllistado" class="table table-bordered table-hover table-condensed mb-4">
                                    <thead>
                                        <th width="5%">ID</th>
                                        <th width="10%">ALMACEN</th>
                                        <th width="10%">TIPO INGRESO</th>
                                        <th width="10%">COMPROBANTE</th>
                                        <th width="30%">EXISTENCIA</th>
                                        <th width="5%">PRECIO</th>
                                        <th width="5%">CANT.</th>
                                        <th width="5%">UM</th>
                                        <th width="10%">SUBTOTAL</th>
                                        <th width="10%">OPCIONES</th>

                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
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


<script>
    $.fn.dataTable.ext.search.push(
        function(settings, data, dataIndex) {
            var min = parseFloat($('#min').val()).toFixed(2);
            var max = parseFloat($('#max').val()).toFixed(2);
            var value = parseFloat(data[8]) || 0;
            console.log(value);
            // Considera la columna numérica en el ejemplo

            if ((isNaN(min) && isNaN(max)) ||
                (isNaN(min) && value <= max) ||
                (min <= value && isNaN(max)) ||
                (min <= value && value <= max)) {
                return true;
            }
            return false;
        }
    );

    $(document).ready(function() {
        var table = $('#tbllistado').DataTable({
            dom: '<"row"<"col-md-12"<"row"<"col-md-6"B><"col-md-6"f> > ><"col-md-12"rt> <"col-md-12"<"row"<"col-md-5"i><"col-md-7"p>>> >',
            buttons: {
                buttons: [{
                        extend: 'copy',
                        className: 'btn'
                    },
                    {
                        extend: 'csv',
                        className: 'btn'
                    },
                    {
                        extend: 'excel',
                        className: 'btn'
                    },
                    {
                        extend: 'print',
                        className: 'btn'
                    },
                    {
                        extend: 'pageLength',
                        className: 'btn'
                    }
                ]
            },
            "oLanguage": {
                "oPaginate": {
                    "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                    "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
                },
                "sInfo": "Mostrando página _PAGE_ de _PAGES_",
                "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                "sSearchPlaceholder": "Buscar...",
                "sLengthMenu": "Results :  _MENU_",
            },
            "stripeClasses": [],
            "lengthMenu": [10, 20, 50, 100],
            "pageLength": 10,

            "ajax": {
                url: '../controlador/ingreso.php?op=listar',
                type: "get",
                dataType: "json",
                error: function(e) {
                    console.log(e.responseText);
                }
            },

            "columnDefs": [{
                    "targets": 5, // Indica la columna "Monto"
                    "render": function(data, type, row) {
                        return parseFloat(data).toFixed(2); // Agrega el símbolo y formatea el número
                    }
                },
                {
                    "targets": 8, // Indica la columna "Monto"
                    "render": function(data, type, row) {
                        return parseFloat(data).toFixed(2); // Agrega el símbolo y formatea el número
                    }
                }
            ],

            "order": [
                [0, "desc"]
            ] //ordenar (columna, orden)

        });

        $('#min, #max').keyup(function() {
            table.draw();
        });
    });
</script>
<?php
?>