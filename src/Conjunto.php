<?php
class Conjunto
{
    public $a;
    public $b;

    public function __construct($a, $b)
    {
        // Quitar repetidos: en un conjunto cada elemento aparece una sola vez
        $this->a = array_values(array_unique($a));
        $this->b = array_values(array_unique($b));
    }

    // Unión: todos los elementos de A y de B
    public function union()
    {
        $resultado = array_unique(array_merge($this->a, $this->b));
        sort($resultado);
        return $resultado;
    }

    // Intersección: los elementos que están en A y también en B
    public function interseccion()
    {
        $resultado = array_intersect($this->a, $this->b);
        sort($resultado);
        return $resultado;
    }

    // Diferencia A - B: los elementos de A que no están en B
    public function diferenciaAB()
    {
        $resultado = array_diff($this->a, $this->b);
        sort($resultado);
        return $resultado;
    }

    // Diferencia B - A: los elementos de B que no están en A
    public function diferenciaBA()
    {
        $resultado = array_diff($this->b, $this->a);
        sort($resultado);
        return $resultado;
    }

    // Convierte un conjunto en texto, por ejemplo { 1, 2, 3 }
    public function texto($conjunto)
    {
        if (count($conjunto) == 0) {
            return "{ } (conjunto vacío)";
        }
        return "{ " . implode(", ", $conjunto) . " }";
    }
}
