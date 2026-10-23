<?php
class Secuencias
{
    private int $n;

    public function __construct(int $n)
    {
        if ($n < 0) {
            throw new InvalidArgumentException('El número debe ser mayor o igual a 0.');
        }
        $this->n = $n;
    }

    // Primeros n términos de Fibonacci: 0, 1, 1, 2, 3, 5...
    public function fibonacci(): array
    {
        if ($this->n > 90) {
            throw new InvalidArgumentException('Para Fibonacci usa un número hasta 90.');
        }
        $serie = [];
        $a = 0;
        $b = 1;
        for ($i = 0; $i < $this->n; $i++) {
            $serie[] = $a;
            [$a, $b] = [$b, $a + $b];
        }
        return $serie;
    }

    // Factoriales de 0 hasta n: 0!, 1!, 2!... n!
    public function factorial(): array
    {
        if ($this->n > 20) {
            throw new InvalidArgumentException('Para factorial usa un número hasta 20.');
        }
        $serie = [];
        $resultado = 1;
        for ($i = 0; $i <= $this->n; $i++) {
            if ($i > 0) {
                $resultado *= $i;
            }
            $serie[] = $resultado;
        }
        return $serie;
    }
}