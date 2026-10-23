
<?php
class Secuencias
{
    public $numero;

    public function __construct($numero)
    {
        $this->numero = $numero;
    }

    // Devuelve los primeros "numero" términos de Fibonacci: 0, 1, 1, 2, 3, 5...
    public function fibonacci()
    {
        $serie = array();
        $anterior = 0;
        $actual = 1;

        for ($i = 0; $i < $this->numero; $i++) {
            $serie[] = $anterior;

            // Cada término es la suma de los dos anteriores
            $siguiente = $anterior + $actual;
            $anterior = $actual;
            $actual = $siguiente;
        }

        return $serie;
    }

    // Devuelve los factoriales de 0 hasta "numero": 0!, 1!, 2!... n!
    public function factorial()
    {
        $serie = array();
        $resultado = 1;

        for ($i = 0; $i <= $this->numero; $i++) {
            if ($i > 0) {
                $resultado = $resultado * $i;
            }
            $serie[] = $resultado;
        }

        return $serie;
    }
}