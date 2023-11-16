    $("#frmAcceso").on('submit', function(e) {
        e.preventDefault();
        var logina = $("#logina").val();
        var clavea = $("#clavea").val();

        $.post("../controlador/usuario.php?op=verificar", 
        {
            "logina": logina, 
            "clavea": clavea
        },
         function(data) {
            if (data !== "null") {
                // Redirige al usuario a la página de escritorio si el inicio de sesión es exitoso
                $(location).attr("href","escritorio.php");
            } else {
                // Muestra un mensaje de error al usuario
                $("#login-error-message").text("Usuario y/o contraseña incorrectos");
            }
        });
    });
