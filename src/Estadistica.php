<?php
class Estadistica
{
    public $numeros;

    public function __construct($numeros)
    {
        $this->numeros = $numeros;
    }

    // Media (promedio): suma de todos / cantidad
    public function media()
    {
        $suma = array_sum($this->numeros);
        return $suma / count($this->numeros);
    }

    // Mediana: el valor del centro de la lista ordenada
    public function mediana()
    {
        $lista = $this->numeros;
        sort($lista);
        $total = count($lista);
        $mitad = floor($total / 2);

        if ($total % 2 == 0) {
            // Cantidad par: promedio de los dos del centro
            return ($lista[$mitad - 1] + $lista[$mitad]) / 2;
        } else {
            // Cantidad impar: el del centro
            return $lista[$mitad];
        }
    }

    // Moda: el número (o números) que más se repite
    public function moda()
    {
        // Contar cuántas veces aparece cada número
        $conteo = array();
        foreach ($this->numeros as $numero) {
            $clave = "n" . $numero; // el "n" evita problemas con decimales como clave
            if (isset($conteo[$clave])) {
                $conteo[$clave] = $conteo[$clave] + 1;
            } else {
                $conteo[$clave] = 1;
            }
        }

        // Buscar la mayor cantidad de repeticiones
        $maximo = max($conteo);

        // Si el máximo es 1, ningún número se repite
        if ($maximo == 1) {
            return array();
        }

        // Guardar todos los números que tienen esa cantidad
        $modas = array();
        foreach ($conteo as $clave => $veces) {
            if ($veces == $maximo) {
                $modas[] = substr($clave, 1); // quitar la "n" del inicio
            }
        }
        return $modas;
    }
}