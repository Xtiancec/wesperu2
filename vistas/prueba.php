<?php
//activamos almacenamiento en el buffer
require 'layout/header.php';
require 'layout/navbar.php';
require 'layout/sidebar.php';
?>

<!DOCTYPE html>
<html>
    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Empresa de Fabricación y Mantenimiento</title>
    <link rel="stylesheet" type="text/css" href="scripts/prueba.css">
</head>
<body>
    <header>
        <h1>Empresa de Fabricación y Mantenimiento</h1>
    </header>

    <nav>
        <ul>
            <li><a href="#descripcion">Descripción</a></li>
            <li><a href="#servicios">Servicios</a></li>
            <li><a href="#redes-sociales">Redes Sociales</a></li>
        </ul>
    </nav>

    <section id="descripcion">
        <h2>Descripción de la Empresa</h2>
        <p>Tu empresa de fabricación y mantenimiento es líder en la industria, brindando soluciones de alta calidad a clientes de todo el mundo. Nuestro compromiso es ofrecer productos y servicios excepcionales que satisfagan las necesidades de nuestros clientes.</p>
    </section>

    <section id="servicios">
        <h2>Nuestros Servicios</h2>
        <ul>
            <li>Fabricación de productos personalizados</li>
            <li>Mantenimiento preventivo y correctivo</li>
            <li>Consultoría especializada</li>
            <li>Soporte técnico 24/7</li>
        </ul>
    </section>

    <section id="redes-sociales">
        <h2>Redes Sociales</h2>
        <p>Síguenos en nuestras redes sociales para mantenerte al tanto de las últimas noticias y actualizaciones:</p>
        <ul>
            <li><a href="https://www.facebook.com/tuempresa" target="_blank">Facebook</a></li>
            <li><a href="https://twitter.com/tuempresa" target="_blank">Twitter</a></li>
            <li><a href="https://www.linkedin.com/company/tuempresa" target="_blank">LinkedIn</a></li>
        </ul>
    </section>

    <footer>
        <p>&copy; 2023 Tu Empresa de Fabricación y Mantenimiento</p>
    </footer>
</body>
</html>


<?php
require 'layout/footer.php';
?>  