<?php
class Salidas
{
    private $conn;

    public function __construct()
    {
        // Establece la conexión a la base de datos en el constructor
        $host = 'localhost';
        $usuario = 'root';
        $clave = '';
        $base_de_datos = 'almacen';

        try {
            $this->conn = new PDO("mysql:host=$host;dbname=$base_de_datos;charset=utf8", $usuario, $clave);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }

    function registrarSalida($idExistencia, $cantidad)
    {
        try {
            $this->conn->beginTransaction();

            // Obtén los ingresos más antiguos relacionados con la existencia
            $query = $this->conn->prepare("SELECT idIngreso, precio, cantidad FROM ingreso WHERE idExistencia = :idExistencia AND cantidad > 0 ORDER BY created_at");
            $query->bindParam(":idExistencia", $idExistencia);
            $query->execute();

            $subtotal = 0;
            $costoUnitarioFIFO = 0; // Nuevo

            while ($ingreso = $query->fetch(PDO::FETCH_ASSOC)) {
                $idIngreso = $ingreso["idIngreso"];
                $precioUnitario = $ingreso["precio"];
                $cantidadDisponible = $ingreso["cantidad"];

                if ($cantidad <= $cantidadDisponible) {
                    // Registrar la salida en la tabla 'salida'
                    $insertQuery = $this->conn->prepare("INSERT INTO salida (idExistencia, idIngreso, cantidad, costoUnitario, subTotal, fecha) VALUES (:idExistencia, :idIngreso, :cantidad, :costoUnitario, :subTotal, NOW())");
                    $insertQuery->bindParam(":idExistencia", $idExistencia);
                    $insertQuery->bindParam(":idIngreso", $idIngreso);
                    $insertQuery->bindParam(":cantidad", $cantidad);
                    $insertQuery->bindParam(":costoUnitario", $precioUnitario);
                    $insertQuery->bindParam(":subTotal", $cantidad * $precioUnitario);
                    $insertQuery->execute();

                    // Nuevo: Almacenar el costo unitario FIFO
                    $costoUnitarioFIFO = $precioUnitario;

                    // Actualizar el stock en la tabla 'existencia' y el ingreso
                    $updateExistenciaQuery = $this->conn->prepare("UPDATE existencia SET stockActual = stockActual - :cantidad WHERE idExistencia = :idExistencia");
                    $updateExistenciaQuery->bindParam(":idExistencia", $idExistencia);
                    $updateExistenciaQuery->bindParam(":cantidad", $cantidad);
                    $updateExistenciaQuery->execute();

                    $updateIngresoQuery = $this->conn->prepare("UPDATE ingreso SET cantidad = cantidad - :cantidad WHERE idIngreso = :idIngreso");
                    $updateIngresoQuery->bindParam(":idIngreso", $idIngreso);
                    $updateIngresoQuery->bindParam(":cantidad", $cantidad);
                    $updateIngresoQuery->execute();

                    $subtotal += $cantidad * $precioUnitario;
                    break;
                } else {
                    // Registrar la salida parcial de este ingreso
                    $insertQuery = $this->conn->prepare("INSERT INTO salida (idExistencia, idIngreso, cantidad, costoUnitario, subTotal, fecha) VALUES (:idExistencia, :idIngreso, :cantidad, :costoUnitario, :subTotal, NOW())");
                    $insertQuery->bindParam(":idExistencia", $idExistencia);
                    $insertQuery->bindParam(":idIngreso", $idIngreso);
                    $insertQuery->bindParam(":cantidad", $cantidadDisponible);
                    $insertQuery->bindParam(":costoUnitario", $precioUnitario);
                    $insertQuery->bindParam(":subTotal", $cantidadDisponible * $precioUnitario);
                    $insertQuery->execute();

                    // Nuevo: Actualizar el costo unitario FIFO
                    $costoUnitarioFIFO = $precioUnitario;

                    // Actualizar el stock en la tabla 'existencia' y el ingreso
                    $updateExistenciaQuery = $this->conn->prepare("UPDATE existencia SET stockActual = stockActual - :cantidad WHERE idExistencia = :idExistencia");
                    $updateExistenciaQuery->bindParam(":idExistencia", $idExistencia);
                    $updateExistenciaQuery->bindParam(":cantidad", $cantidadDisponible);
                    $updateExistenciaQuery->execute();

                    $updateIngresoQuery = $this->conn->prepare("UPDATE ingreso SET cantidad = cantidad - :cantidad WHERE idIngreso = :idIngreso");
                    $updateIngresoQuery->bindParam(":idIngreso", $idIngreso);
                    $updateIngresoQuery->bindParam(":cantidad", $cantidadDisponible);
                    $updateIngresoQuery->execute();

                    $subtotal += $cantidadDisponible * $precioUnitario;
                    $cantidad -= $cantidadDisponible;
                }
            }

            $this->conn->commit();
            return $costoUnitarioFIFO;
        } catch (PDOException $e) {
            $this->conn->rollBack();
            return "Error al registrar la salida: " . $e->getMessage();
        }
    }
}
