<?php

namespace Alura\Leilao\Model;

class Lance
{
    public function __construct(private Usuario $usuario, private int|float $valor)
    {
    }

    public function getUsuario(): Usuario
    {
        return $this->usuario;
    }

    public function getValor(): float
    {
        return $this->valor;
    }
}
