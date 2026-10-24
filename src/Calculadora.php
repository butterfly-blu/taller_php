<?php
class Calculadora
{
    // Realiza la operación y devuelve el resultado
    public function calcular($a, $b, $operacion)
    {
        if ($operacion == "suma") {
            return $a + $b;
        } elseif ($operacion == "resta") {
            return $a - $b;
        } elseif ($operacion == "multiplicacion") {
            return $a * $b;
        } elseif ($operacion == "division") {
            if ($b == 0) {
                throw new Exception("No se puede dividir entre cero.");
            }
            return $a / $b;
        } elseif ($operacion == "porcentaje") {
            // a % de b  (por ejemplo, 20% de 150 = 30)
            return ($a / 100) * $b;
        } else {
            throw new Exception("Operación no válida.");
        }
    }

    // Texto del símbolo de cada operación
    public function simbolo($operacion)
    {
        if ($operacion == "suma") {
            return "+";
        } elseif ($operacion == "resta") {
            return "-";
        } elseif ($operacion == "multiplicacion") {
            return "×";
        } elseif ($operacion == "division") {
            return "÷";
        } else {
            return "% de";
        }
    }

    // Guarda una operación al inicio del historial
    public function guardar($texto)
    {
        if (!isset($_SESSION['historial'])) {
            $_SESSION['historial'] = array();
        }
        array_unshift($_SESSION['historial'], $texto);
    }

    // Devuelve la lista del historial
    public function obtenerHistorial()
    {
        if (isset($_SESSION['historial'])) {
            return $_SESSION['historial'];
        }
        return array();
    }

    // Borra todo el historial
    public function borrarHistorial()
    {
        $_SESSION['historial'] = array();
    }
}
