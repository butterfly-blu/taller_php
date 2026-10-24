<?php
class Acronimo
{
    private string $frase;

    public function __construct(string $frase)
    {
        $this->frase = $frase;
    }

    public function generar(): string
    {
        // Los guiones cuentan como separadores
        $texto = str_replace('-', ' ', $this->frase);
        // Se eliminan los demás signos de puntuación (se conservan letras, números y espacios)
        $texto = preg_replace('/[^\p{L}\p{N}\s]/u', '', $texto);
        $palabras = preg_split('/\s+/', trim($texto), -1, PREG_SPLIT_NO_EMPTY);

        $sigla = '';
        foreach ($palabras as $palabra) {
            $sigla .= mb_strtoupper(mb_substr($palabra, 0, 1));
        }
        return $sigla;
    }
}
