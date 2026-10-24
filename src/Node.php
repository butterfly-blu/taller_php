<?php
class Node
{
    public $valor;
    public $izquierdo;
    public $derecho;

    public function __construct($valor)
    {
        $this->valor = $valor;
        $this->izquierdo = null;
        $this->derecho = null;
    }
}
