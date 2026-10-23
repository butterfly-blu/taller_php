<?php
$base = '../';
require_once __DIR__ . '/../src/Fibonacci.php';

$serie = null;
$error = null;
$operacion = $_POST['operacion'] ?? 'fibonacci';
$numero = $_POST['numero'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (filter_var($numero, FILTER_VALIDATE_INT) === false) {
        $error = 'Ingresa un número entero válido.';
    } else {
        try {
            $secuencias = new Secuencias((int) $numero);
            $serie = ($operacion === 'factorial')
                ? $secuencias->factorial()
                : $secuencias->fibonacci();
        } catch (InvalidArgumentException $e) {
            $error = $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Fibonacci / Factorial</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
    <?php include __DIR__ . '/../Menu.php'; ?>
    <main>
        <h1>Sucesión de Fibonacci o factorial</h1>
        <form method="post">
            <label>Número:
                <input type="number" name="numero" min="0" value="<?= htmlspecialchars($numero) ?>" required>
            </label>
            <label>Operación:
                <select name="operacion">
                    <option value="fibonacci" <?= $operacion === 'fibonacci' ? 'selected' : '' ?>>Sucesión de Fibonacci</option>
                    <option value="factorial" <?= $operacion === 'factorial' ? 'selected' : '' ?>>Factorial</option>
                </select>
            </label>
            <button type="submit">Calcular</button>
        </form>

        <?php if ($error): ?>
            <p class="resultado" style="background:#f8e0e0"><?= htmlspecialchars($error) ?></p>
        <?php elseif ($serie !== null): ?>
            <p class="resultado">
                <?= $operacion === 'factorial' ? 'Factoriales de 0 a ' . (int) $numero : 'Primeros ' . (int) $numero . ' términos de Fibonacci' ?>:<br>
                <strong><?= implode(', ', $serie) ?></strong>
            </p>
        <?php endif; ?>
    </main>
</body>
</html>