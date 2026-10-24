<?php

require_once __DIR__ . '/Node.php';

class ArbolBinario
{
    public $raiz = null;
    public $metodo = "";
    public $ambiguo = false; // true si con pre-post el árbol no es único

    // Recibe los tres recorridos (arreglos; vacío si el usuario no lo ingresó)
    public function construir($pre, $in, $post)
    {
        $this->revisarRepetidos($pre);
        $this->revisarRepetidos($in);
        $this->revisarRepetidos($post);

        if (count($pre) > 0 && count($in) > 0) {
            // Si ingresa los tres, se usa preorden - inorden
            $this->metodo = "Preorden - Inorden";
            $this->raiz = $this->construirPreIn($pre, $in);
            $this->verificar($pre, $in, array());
        } elseif (count($in) > 0 && count($post) > 0) {
            $this->metodo = "Inorden - Postorden";
            $this->raiz = $this->construirInPost($in, $post);
            $this->verificar(array(), $in, $post);
        } elseif (count($pre) > 0 && count($post) > 0) {
            $this->metodo = "Preorden - Postorden";
            $this->raiz = $this->construirPrePost($pre, $post);
            $this->verificar($pre, array(), $post);
        } else {
            throw new Exception("Debes ingresar al menos dos recorridos.");
        }
    }

    // Un árbol no puede tener nodos repetidos
    private function revisarRepetidos($lista)
    {
        if (count($lista) != count(array_unique($lista))) {
            throw new Exception("Los recorridos no pueden tener elementos repetidos.");
        }
    }

    // Preorden + Inorden
    private function construirPreIn($pre, $in)
    {
        if (count($pre) == 0 || count($in) == 0) {
            return null;
        }

        $nodo = new Node($pre[0]);          // la raíz es el primero del preorden
        $pos = array_search($pre[0], $in, true);
        if ($pos === false) {
            throw new Exception("Los recorridos no corresponden al mismo árbol.");
        }

        // Partes izquierda y derecha en cada recorrido
        $inIzq = array_slice($in, 0, $pos);
        $inDer = array_slice($in, $pos + 1);
        $preIzq = array_slice($pre, 1, $pos);
        $preDer = array_slice($pre, 1 + $pos);

        $nodo->izquierdo = $this->construirPreIn($preIzq, $inIzq);
        $nodo->derecho = $this->construirPreIn($preDer, $inDer);
        return $nodo;
    }

    // Inorden + Postorden
    private function construirInPost($in, $post)
    {
        if (count($in) == 0 || count($post) == 0) {
            return null;
        }

        $raiz = $post[count($post) - 1];    // la raíz es el último del postorden
        $nodo = new Node($raiz);
        $pos = array_search($raiz, $in, true);
        if ($pos === false) {
            throw new Exception("Los recorridos no corresponden al mismo árbol.");
        }

        $inIzq = array_slice($in, 0, $pos);
        $inDer = array_slice($in, $pos + 1);
        $postIzq = array_slice($post, 0, $pos);
        $postDer = array_slice($post, $pos, count($in) - $pos - 1);

        $nodo->izquierdo = $this->construirInPost($inIzq, $postIzq);
        $nodo->derecho = $this->construirInPost($inDer, $postDer);
        return $nodo;
    }

    // Preorden + Postorden
    private function construirPrePost($pre, $post)
    {
        if (count($pre) == 0 || count($post) == 0) {
            return null;
        }

        $nodo = new Node($pre[0]);
        $n = count($pre);

        // Si solo hay un elemento, es una hoja
        if ($n == 1) {
            return $nodo;
        }

        // pre[1] es la raíz del subárbol izquierdo; su lugar en el postorden
        // dice cuántos elementos tiene ese subárbol
        $i = array_search($pre[1], $post, true);
        if ($i === false) {
            throw new Exception("Los recorridos no corresponden al mismo árbol.");
        }
        $tam = $i + 1;

        if ($tam > $n - 1) {
            throw new Exception("Los recorridos no corresponden al mismo árbol.");
        }

        // Si el subárbol izquierdo ocupa todo, el nodo tiene un solo hijo
        // y no se sabe si es izquierdo o derecho
        if ($tam == $n - 1) {
            $this->ambiguo = true;
        }

        $preIzq = array_slice($pre, 1, $tam);
        $postIzq = array_slice($post, 0, $tam);
        $preDer = array_slice($pre, 1 + $tam);
        $postDer = array_slice($post, $tam, $n - 1 - $tam);

        $nodo->izquierdo = $this->construirPrePost($preIzq, $postIzq);
        $nodo->derecho = $this->construirPrePost($preDer, $postDer);
        return $nodo;
    }

    // Recorridos del árbol ya construido
    public function preorden($nodo)
    {
        if ($nodo == null) {
            return array();
        }
        return array_merge(array($nodo->valor), $this->preorden($nodo->izquierdo), $this->preorden($nodo->derecho));
    }

    public function inorden($nodo)
    {
        if ($nodo == null) {
            return array();
        }
        return array_merge($this->inorden($nodo->izquierdo), array($nodo->valor), $this->inorden($nodo->derecho));
    }

    public function postorden($nodo)
    {
        if ($nodo == null) {
            return array();
        }
        return array_merge($this->postorden($nodo->izquierdo), $this->postorden($nodo->derecho), array($nodo->valor));
    }

    // Comprueba que el árbol construido produce los mismos recorridos ingresados
    private function verificar($pre, $in, $post)
    {
        if (count($pre) > 0 && implode(",", $pre) != implode(",", $this->preorden($this->raiz))) {
            throw new Exception("Los recorridos ingresados no corresponden a ningún árbol.");
        }
        if (count($in) > 0 && implode(",", $in) != implode(",", $this->inorden($this->raiz))) {
            throw new Exception("Los recorridos ingresados no corresponden a ningún árbol.");
        }
        if (count($post) > 0 && implode(",", $post) != implode(",", $this->postorden($this->raiz))) {
            throw new Exception("Los recorridos ingresados no corresponden a ningún árbol.");
        }
    }
}
