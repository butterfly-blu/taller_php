<?php
session_start(); // siempre antes de cualquier HTML
$base = '../';
require_once __DIR__ . '/../src/Calculadora.php';

$calculadora = new Calculadora();
$mensaje = "";

// Botón "Borrar historial"
if (isset($_POST['borrar'])) {
    $calculadora->borrarHistorial();
    header("Location: calculadora.php");
    exit;
}

// Botón "Calcular"
if (isset($_POST['calcular'])) {
    $num1 = trim($_POST['num1']);
    $num2 = trim($_POST['num2']);
    $operacion = $_POST['operacion'];

    if (!is_numeric($num1) || !is_numeric($num2)) {
        $mensaje = "Ingresa números válidos (enteros o decimales).";
    } else {
        try {
            $resultado = $calculadora->calcular((float) $num1, (float) $num2, $operacion);
            $simbolo = $calculadora->simbolo($operacion);
            $texto = $num1 . " " . $simbolo . " " . $num2 . " = " . round($resultado, 4);
            $calculadora->guardar($texto);

            // Redirigir evita que al recargar la página se repita la operación
            header("Location: calculadora.php");
            exit;
        } catch (Exception $e) {
            $mensaje = $e->getMessage();
        }
    }
}

$historial = $calculadora->obtenerHistorial();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Calculadora</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
    <?php include __DIR__ . '/../Menu.php'; ?>
    <main>
        <h1>Calculadora</h1>

        <form method="post">
            <input type="number" step="any" name="num1" placeholder="Primer número" required>

            <select name="operacion">
                <option value="suma">Suma (+)</option>
                <option value="resta">Resta (-)</option>
                <option value="multiplicacion">Multiplicación (×)</option>
                <option value="division">División (÷)</option>
                <option value="porcentaje">Porcentaje (% de)</option>
            </select>

            <input type="number" step="any" name="num2" placeholder="Segundo número" required>

            <button type="submit" name="calcular">Calcular</button>
        </form>


        <?php if (count($historial) > 0) { ?>
            <div class="resultado">
                <p>Último resultado: <strong><?php echo htmlspecialchars($historial[0]); ?></strong></p>
            </div>
        <?php } ?>

        <h3>Historial</h3>
        <?php if (count($historial) == 0) { ?>
            <p>Todavía no hay operaciones.</p>
        <?php } else { ?>
            <ul>
                <?php foreach ($historial as $operacion) { ?>
                    <li><?php echo htmlspecialchars($operacion); ?></li>
                <?php } ?>
            </ul>
            <form method="post">
                <button type="submit" name="borrar">Borrar historial</button>
            </form>
        <?php } ?>
    </main>
</body>
</html>