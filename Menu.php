<?php
$base = $base ?? '';
$opciones = [
    'acronimo.php'            => '1. Acrónimos',
    'fibonacci.php' => '2. Fibonacci / Factorial',
    'estadistica.php'         => '3. Estadística',
    'conjunto.php'           => '4. Conjuntos',
    'convertir.php'             => '5. Binario',
    'arbol_binario.php'               => '6. Árbol binario',
    'calculadora.php'         => '7. Calculadora',
];
?>
<nav class="menu">
    <a href="<?= $base ?>index.php" class="inicio">Inicio</a>
    <?php foreach ($opciones as $archivo => $titulo): ?>
        <a href="<?= $base ?>apps/<?= $archivo ?>"><?= $titulo ?></a>
    <?php endforeach; ?>
</nav>