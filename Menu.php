<?php
$base = $base ?? '';
$opciones = [
    'acronimo.php'           => ' Acrónimos',
    'fibonacci.php'          => 'Fibonacci / Factorial',
    'estadistica.php'        => ' Estadística',
    'conjunto.php'           => ' Conjuntos',
    'convertir.php'          => ' Binario',
    'arbol_binario.php'      => ' Árbol binario',
    'calculadora.php'        => ' Calculadora',
];
?>
<nav class="menu">
    <a href="<?= $base ?>index.php" class="inicio">Inicio</a>
    <link rel="stylesheet" href="css/estilos.css">
    <?php foreach ($opciones as $archivo => $titulo): ?>
        <a href="<?= $base ?>apps/<?= $archivo ?>"><?= $titulo ?></a>
    <?php endforeach; ?>
</nav>