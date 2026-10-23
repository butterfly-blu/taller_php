<?php
class Binario
{
    public $numero;
    public $pasos;

    public function __construct($numero)
    {
        $this->numero = $numero;
        $this->pasos = array();
    }

    // Convierte el número entero a binario dividiendo entre 2
    public function convertir()
    {
        // Caso especial: el 0 es 0 en binario
        if ($this->numero == 0) {
            return "0";
        }

        // Trabajamos con el valor sin signo (si es negativo, el signo se agrega al final)
        $n = abs($this->numero);
        $binario = "";

        while ($n > 0) {
            $residuo = $n % 2;
            $cociente = intdiv($n, 2);

            // Guardar el paso para mostrarlo en pantalla
            $this->pasos[] = array($n, $cociente, $residuo);

            // Cada residuo se coloca al inicio del resultado
            $binario = $residuo . $binario;
            $n = $cociente;
        }

        // Si el número original era negativo, se agrega el signo
        if ($this->numero < 0) {
            $binario = "-" . $binario;
        }

        return $binario;
    }
}