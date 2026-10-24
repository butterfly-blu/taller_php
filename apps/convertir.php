<?php
$base = '../';
require_once '../src/Convertir.php';

$numero = "";
$mensaje = "";
$resultado = false;

if (isset($_POST['numero'])) {
    $numero = trim($_POST['numero']);

    if (filter_var($numero, FILTER_VALIDATE_INT) === false) {
        $mensaje = "Ingresa un número entero válido (sin decimales).";
    } else {
        $conversor = new Binario((int) $numero);
        $binario = $conversor->convertir();
        $resultado = true;
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Convertir a binario</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>

<body>
    <?php include '../Menu.php'; ?>
    <main>
        <h1>Convertir un entero a binario</h1>

        <form method="post">
            <label>Número entero:</label><br>
            <input type="number" name="numero" value="<?php echo htmlspecialchars($numero); ?>" required>
            <button type="submit">Convertir</button>
        </form>

        <?php if ($mensaje != "") { ?>
            <p class="resultado"><?php echo $mensaje; ?></p>
        <?php } ?>

        <?php if ($resultado) { ?>
            <div class="resultado">
                <p>El número <strong><?php echo (int) $numero; ?></strong> en binario es:</p>
                <p style="font-size: 1.5rem"><strong><?php echo $binario; ?></strong></p>
            </div>

            <?php if (count($conversor->pasos) > 0) { ?>
                <h3>Procedimiento (divisiones entre 2)</h3>
                <table border="1" cellpadding="6" cellspacing="0">
                    <tr>
                        <th>Número</th>
                        <th>Cociente</th>
                        <th>Residuo</th>
                    </tr>
                    <?php foreach ($conversor->pasos as $paso) { ?>
                        <tr>
                            <td><?php echo $paso[0]; ?></td>
                            <td><?php echo $paso[1]; ?></td>
                            <td><?php echo $paso[2]; ?></td>
                        </tr>
                    <?php } ?>
                </table>
                <p>Los residuos se leen de abajo hacia arriba.</p>
            <?php } ?>
        <?php } ?>
    </main>
</body>

</html>