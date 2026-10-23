<?php
include  '/../src/Acronimo.php';
$resultado = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $resultado = (new Acronimo($_POST['frase'] ?? ''))->generar();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Acrónimos</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
    <?php include '/../Menu.php'; ?>
    <main>
        <h1>Convertir frase en acrónimo</h1>
        <form method="post">
            <input type="text" name="frase" placeholder="Thank George It's Friday!" required>
            <button type="submit">Convertir</button>
        </form>
        <?php if ($resultado !== null): ?>
            <p class="resultado">Acrónimo: <strong><?= htmlspecialchars($resultado) ?></strong></p>
        <?php endif; ?>
    </main>
</body>
</html>