<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php
$paginaActual = "login";
require_once '../includes/config.php';
include '../includes/header.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST['email'];
    $contrasena = $_POST['contrasena'];

    $sql = "SELECT * FROM personal WHERE email = '$email' AND contrasena = '$contrasena'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        session_start();
        $_SESSION['personal'] = $email;
        if (isset($_SESSION['personal'])) {
            $emailSesion = $_SESSION['personal'];
            $query = "SELECT * FROM personal WHERE email = '$emailSesion'";
            $resultado = mysqli_query($conn, $query);
            foreach ($resultado as $personal) {
                $idSesion = $personal['ID_Personal'];
                $nombreSesion = $personal['nombre'];
                $apellidoSesion = $personal['apellido'];
                $emailSesion = $personal['email'];
                $rolSesion = $personal['rol'];
            }
        }

        if ($rolSesion == "Administrador") {?>
            <script>
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Bienvenido',
                text: '<?= $nombreSesion . " " . $apellidoSesion ?>',
                showConfirmButton: false,
                timer: 2000
            }).then(function() {
                window.location.href = '<?php echo BASE_URL; ?>dashboard/';
            })

        </script>
        <?php
        } else if ($rolSesion == "Ventas") {?>
            <script>
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Bienvenido',
                text: '<?= $nombreSesion . " " . $apellidoSesion ?>',
                showConfirmButton: false,
                timer: 2000
            }).then(function(){
                window.location.href = '<?php echo BASE_URL; ?>ventas/';
            })
        </script>
        <?php
        } else if ($rolSesion == "Almacenes") {?>
            <script>
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Bienvenido',
                text: '<?= $nombreSesion . " " . $apellidoSesion ?>',
                showConfirmButton: false,
                timer: 1500
            }).then(function(){
                window.location.href = '<?php echo BASE_URL; ?>farmacos/';
            })
        </script>
        <?php
        }
    } else {
        session_start();
        $_SESSION['mensaje'] = "Email o contraseña incorrecta";
        //echo "Contraseña incorrecta";
        header("Location: " . BASE_URL . "login/");
    }
}
