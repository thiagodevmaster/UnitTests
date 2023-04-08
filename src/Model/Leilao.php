<?php

namespace Alura\Leilao\Model;

class Leilao
{
    private array $lances;
    private bool $finalizado;

    public function __construct(private string $descricao)
    {
        $this->finalizado = false;
        $this->lances = [];
    }

    public function recebeLance(Lance $lance)
    {
        if(!empty($this->lances) && $lance->getUsuario() == $this->lances[count($this->lances) - 1]->getUsuario()){
            return;   
        }

        $totalLancesUsuario = $this->quantidadeLancesPorUsuario($lance->getUsuario());
        if ($totalLancesUsuario >= 5) {
            return;
        }

        $this->lances[] = $lance;
    }

    public function getLances(): array
    {
        return $this->lances;
    }

    public function getFinalizado(): bool
    {
        return $this->finalizado;
    }
    
    public function finaliza(): void
    {
        $this->finalizado = true;
    }

    private function quantidadeLancesPorUsuario(Usuario $usuario): int
    {
        $ocorrencias = 0;

        if(!empty($this->lances)){
            foreach($this->lances as $lance){
                if($lance->getUsuario() === $usuario){
                    $ocorrencias += 1;
                }
            }
        }
        
        return $ocorrencias;
    }
}
