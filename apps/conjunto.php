<?php
$base = '../';
require_once '../src/Conjunto.php';

$textoA = "";
$textoB = "";
$mensaje = "";
$resultado = false;

// Convierte un texto como "1, 2, 3" en un arreglo de números enteros
function leerConjunto($texto)
{
    $numeros = array();
    $partes = explode(",", $texto);
    foreach ($partes as $parte) {
        $parte = trim($parte);
        if ($parte == "") {
            continue; // ignorar espacios o comas de más
        }
        if (filter_var($parte, FILTER_VALIDATE_INT) === false) {
            return false; // no es un número entero
        }
        $numeros[] = (int) $parte;
    }
    return $numeros;
}

if (isset($_POST['conjuntoA']) && isset($_POST['conjuntoB'])) {
    $textoA = $_POST['conjuntoA'];
    $textoB = $_POST['conjuntoB'];

    $a = leerConjunto($textoA);
    $b = leerConjunto($textoB);

    if ($a === false || $b === false) {
        $mensaje = "Los conjuntos solo pueden tener números enteros separados por comas.";
    } else {
        $conjuntos = new Conjunto($a, $b);
        $resultado = true;
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Conjuntos</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>

<body>
    <?php include '../Menu.php'; ?>
    <main>
        <h1>Operaciones entre conjuntos</h1>

        <form method="post">
            <label>Conjunto A (enteros separados por comas):</label><br>
            <input type="text" name="conjuntoA" value="<?php echo htmlspecialchars($textoA); ?>" placeholder="1, 2, 3, 4" required><br>

            <label>Conjunto B (enteros separados por comas):</label><br>
            <input type="text" name="conjuntoB" value="<?php echo htmlspecialchars($textoB); ?>" placeholder="3, 4, 5, 6" required><br>

            <button type="submit">Calcular</button>
        </form>

        <?php if ($mensaje != "") { ?>
            <p class="resultado"><?php echo $mensaje; ?></p>
        <?php } ?>

        <?php if ($resultado) { ?>
            <div class="resultado">
                <p>A = <strong><?php echo $conjuntos->texto($conjuntos->a); ?></strong></p>
                <p>B = <strong><?php echo $conjuntos->texto($conjuntos->b); ?></strong></p>
                <hr>
                <p>Unión (A ∪ B) = <strong><?php echo $conjuntos->texto($conjuntos->union()); ?></strong></p>
                <p>Intersección (A ∩ B) = <strong><?php echo $conjuntos->texto($conjuntos->interseccion()); ?></strong></p>
                <p>Diferencia (A - B) = <strong><?php echo $conjuntos->texto($conjuntos->diferenciaAB()); ?></strong></p>
                <p>Diferencia (B - A) = <strong><?php echo $conjuntos->texto($conjuntos->diferenciaBA()); ?></strong></p>
            </div>
        <?php } ?>
    </main>
</body>

</html>