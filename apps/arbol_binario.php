<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
$base = '../';
require_once '../src/Arbol_binario.php';

$textoPre = "";
$textoIn = "";
$textoPost = "";
$mensaje = "";
$resultado = false;

// Convierte "A → B → D" (o con comas, espacios o guiones) en un arreglo
function leerRecorrido($texto)
{
    $texto = trim($texto);
    if ($texto == "") {
        return array();
    }
    return preg_split('/[\s,>→\-]+/u', $texto, -1, PREG_SPLIT_NO_EMPTY);
}

// Dibuja un nodo y sus hijos como listas anidadas
function dibujar($nodo)
{
    echo "<li><span class='node'>" . htmlspecialchars($nodo->valor) . "</span>";
    if ($nodo->izquierdo != null || $nodo->derecho != null) {
        echo "<ul>";
        if ($nodo->izquierdo != null) {
            dibujar($nodo->izquierdo);
        } else {
            echo "<li><span class='nodo vacio'>&nbsp;</span></li>";
        }
        if ($nodo->derecho != null) {
            dibujar($nodo->derecho);
        } else {
            echo "<li><span class='nodo vacio'>&nbsp;</span></li>";
        }
        echo "</ul>";
    }
    echo "</li>";
}

if (isset($_POST['preorden'])) {
    $textoPre = $_POST['preorden'];
    $textoIn = $_POST['inorden'];
    $textoPost = $_POST['postorden'];

    $pre = leerRecorrido($textoPre);
    $in = leerRecorrido($textoIn);
    $post = leerRecorrido($textoPost);

    $arbol = new ArbolBinario();
    try {
        $arbol->construir($pre, $in, $post);
        $resultado = true;
    } catch (Exception $e) {
        $mensaje = $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Árbol binario</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>

<body>
    <?php include '../Menu.php'; ?>
    <main>
        <h1>Construir un árbol binario</h1>
        <p>Ingresa al menos dos recorridos. Separa los elementos con flechas, comas o espacios.</p>

        <form method="post">
            <label>Preorden:</label><br>
            <input type="text" name="preorden" value="<?php echo htmlspecialchars($textoPre); ?>" placeholder="A → B → D → E → C"><br>

            <label>Inorden:</label><br>
            <input type="text" name="inorden" value="<?php echo htmlspecialchars($textoIn); ?>" placeholder="D → B → E → A → C"><br>

            <label>Postorden:</label><br>
            <input type="text" name="postorden" value="<?php echo htmlspecialchars($textoPost); ?>" placeholder="D → E → B → C → A"><br>

            <button type="submit">Construir árbol</button>
        </form>

        <?php if ($mensaje != "") { ?>
            <p class="resultado"><?php echo $mensaje; ?></p>
        <?php } ?>

        <?php if ($resultado) { ?>
            <p>Árbol construido con: <strong><?php echo $arbol->metodo; ?></strong></p>

            <?php if ($arbol->ambiguo) { ?>
                <p class="resultado">
                    Con preorden y postorden el árbol no es único: cuando un nodo tiene un solo hijo
                    no se sabe si es izquierdo o derecho. Se dibujó como hijo izquierdo.
                </p>
            <?php } ?>

            <div class="arbol">
                <ul>
                    <?php dibujar($arbol->raiz); ?>
                </ul>
            </div>

            <div class="resultado">
                <p>Preorden: <strong><?php echo implode(" → ", $arbol->preorden($arbol->raiz)); ?></strong></p>
                <p>Inorden: <strong><?php echo implode(" → ", $arbol->inorden($arbol->raiz)); ?></strong></p>
                <p>Postorden: <strong><?php echo implode(" → ", $arbol->postorden($arbol->raiz)); ?></strong></p>
            </div>
        <?php } ?>
    </main>
</body>

</html>