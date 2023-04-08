<?php

namespace Alura\Leilao\service;

use Alura\Leilao\Model\Lance;
use Alura\Leilao\Model\Leilao;
use DomainException;

class Avaliador
{
    private int|float $maiorValor = 0;
    private int|float $menorValor = INF;
    private array $MaioresLances = [];
    private array $menoresLances = [];

    public function avalia(Leilao $leilao): void
    {
        if(empty($leilao->getLances())){
            throw new DomainException(message:'Não é possível avaliar leilão vazio');
        }

        if($leilao->getFinalizado() === true){
            throw new DomainException('Leilao já está encerrado');
        }

        $lances = $leilao->getLances();

        foreach($lances as $lance){
            if($lance->getValor() > $this->maiorValor){
                $this->maiorValor = $lance->getValor();
            }
            
            if ($lance->getValor() < $this->menorValor){
                $this->menorValor = $lance->getValor();
            }
        }

        usort($lances, function(Lance $lance_um, Lance $lance_dois){
            return $lance_dois->getValor() - $lance_um->getValor();
        });

        $this->MaioresLances = array_slice($lances, 0, 3);
        $this->menoresLances = array_slice($lances, count($lances) - 3, count($lances));
    }

    public function getMaiorValor(): int|float
    {
        return $this->maiorValor;
    }

    public function getMenorValor(): int|float
    {
        return $this->menorValor;
    }

    public function getMaioresLances(): array
    {
        return $this->MaioresLances;
    }

    public function getMenoresLances(): array
    {
        return $this->menoresLances;
    }
}