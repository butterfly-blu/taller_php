<?php
$base = '../';
require_once '../src/Estadistica.php';

$cantidad = 0;
$resultado = false;
$mensaje = "";

// Paso 2: el usuario ya envió los números
if (isset($_POST['numeros'])) {
    $numeros = array();
    foreach ($_POST['numeros'] as $valor) {
        $numeros[] = (float) $valor;
    }
    $estadistica = new Estadistica($numeros);
    $resultado = true;
}
// Paso 1: el usuario ya dijo cuántos números va a ingresar
elseif (isset($_POST['cantidad'])) {
    $cantidad = (int) $_POST['cantidad'];
    if ($cantidad < 1) {
        $mensaje = "La cantidad debe ser al menos 1.";
        $cantidad = 0;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Estadística</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
    <?php include '../Menu.php'; ?>
    <main>
        <h1>Media, mediana y moda</h1>

        <?php if ($mensaje != "") { ?>
            <p class="resultado"><?php echo $mensaje; ?></p>
        <?php } ?>

        <?php if ($cantidad == 0 && $resultado == false) { ?>
            <!-- Paso 1: pedir la cantidad de números -->
            <form method="post">
                <label>¿Cuántos números vas a ingresar?</label><br>
                <input type="number" name="cantidad" min="1" required>
                <button type="submit">Continuar</button>
            </form>
        <?php } ?>

        <?php if ($cantidad > 0) { ?>
            <!-- Paso 2: mostrar un campo por cada número -->
            <form method="post">
                <?php for ($i = 1; $i <= $cantidad; $i++) { ?>
                    <input type="number" step="any" name="numeros[]" placeholder="Número <?php echo $i; ?>" required><br>
                <?php } ?>
                <button type="submit">Calcular</button>
            </form>
        <?php } ?>

        <?php if ($resultado) { ?>
            <!-- Resultados -->
            <div class="resultado">
                <p>Media (promedio): <strong><?php echo $estadistica->media(); ?></strong></p>
                <p>Mediana: <strong><?php echo $estadistica->mediana(); ?></strong></p>
                <p>Moda:
                    <strong>
                    <?php
                    $modas = $estadistica->moda();
                    if (count($modas) == 0) {
                        echo "No hay moda";
                    } else {
                        echo implode(", ", $modas);
                    }
                    ?>
                    </strong>
                </p>
            </div>
            <p><a href="estadistica.php">Calcular otra serie</a></p>
        <?php } ?>
    </main>
</body>
</html>