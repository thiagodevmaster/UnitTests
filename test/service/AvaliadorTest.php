<?php

namespace Alura\Leilao\test\service;

use Alura\Leilao\Model\Lance;
use Alura\Leilao\Model\Leilao;
use Alura\Leilao\Model\Usuario;
use Alura\Leilao\service\Avaliador;
use DomainException;
use PHPUnit\Framework\TestCase;

class AvaliadorTest extends TestCase
{

    private $leiloeiro;

    protected function setUp(): void
    {
        $this->leiloeiro = new Avaliador();
    }

    /**
     * @dataProvider criaLeilaoEmOrdemCrescente
     * @dataProvider criaLeilaoEmOrdemDecrescente
     * @dataProvider criaLeilaoEmOrdemAleatoria
     */
    public function test_Avaliador_Verifica_o_Maior_Lance(Leilao $leilao)
    {

        // executo o código a ser testado (Act - When)
        $this->leiloeiro->avalia($leilao);
        $maiorLance = $this->leiloeiro->getMaiorValor();

        // Determino a saída esperada (Assert - Then);
        $lanceEsperado = 355;

        //também pode-se usar o self::assertEquals() por ser um método estatico.
        $this->assertEquals($lanceEsperado, $maiorLance);
    }

    /**
     * @dataProvider criaLeilaoEmOrdemCrescente
     * @dataProvider criaLeilaoEmOrdemDecrescente
     * @dataProvider criaLeilaoEmOrdemAleatoria
     */
    public function test_Avaliador_Verifica_o_Menor_Lance(Leilao $leilao)
    {
        // executo o código a ser testado (Act - When)
        $this->leiloeiro->avalia($leilao);
        $maiorLance = $this->leiloeiro->getMenorValor();

        // Determino a saída esperada (Assert - Then);
        $lanceEsperado = 50;

        //também pode-se usar o self::assertEquals() por ser um método estatico.
        $this->assertEquals($lanceEsperado, $maiorLance);
    }

    /**
     * @dataProvider criaLeilaoEmOrdemCrescente
     * @dataProvider criaLeilaoEmOrdemDecrescente
     * @dataProvider criaLeilaoEmOrdemAleatoria
     */
    public function test_Avaliador_Verifica_o_Array_Dos_Tres_Maiores_Valores_Estao_Corretos(Leilao $leilao)
    {
        // executo o código a ser testado (Act - When)
        $this->leiloeiro->avalia($leilao);
        $maioresLances = $this->leiloeiro->getMaioresLances();

        // Determino a saída esperada (Assert - Then);
        $this->assertCount(3, $maioresLances);

        //também pode-se usar o self::assertEquals() por ser um método estatico.
        $this->assertEquals(355, $maioresLances[0]->getValor());
        $this->assertEquals(310, $maioresLances[1]->getValor());
        $this->assertEquals(225.0, $maioresLances[2]->getValor());
    }

    public function test_Avaliador_Recebe_Leilao_Sem_Lances()
    {   
        self::expectException(DomainException::class);
        self::expectExceptionMessage('Não é possível avaliar leilão vazio');
        $leilao = new Leilao('Xtz 125 2008');
        $this->leiloeiro->avalia($leilao);
    }


    public function test_Leilao_Finalizado_Nao_Pode_Ser_Avaliado()
    {
        self::expectException(DomainException::class);
        self::expectExceptionMessage('Leilao já está encerrado');

        $leilao = new Leilao('Xtz 125 2008');
        $leilao->recebeLance(new Lance(new Usuario('thiago'), 3500));

        $leilao->finaliza();
        $this->leiloeiro->avalia($leilao);
    }

    /* .--. .-. --- ...- . -.. --- .-. / -.. . / -.. .- -.. --- ... 
                             Provedor de dados                       
    .--. .-. --- ...- . -.. --- .-. / -.. . / -.. .- -.. --- ... */

    public static function criaLeilaoEmOrdemCrescente()
    {
        $leilao = new Leilao('Xtz 125 2008');
        $usuario1 = new Usuario("thiago");
        $usuario2 = new Usuario('beatriz');
        $usuario3 = new Usuario('walter');

        $leilao->recebeLance(new Lance($usuario1, 50));
        $leilao->recebeLance(new Lance($usuario2, 100));
        $leilao->recebeLance(new Lance($usuario3, 139.22));
        $leilao->recebeLance(new Lance($usuario2, 140));
        $leilao->recebeLance(new Lance($usuario1, 170));
        $leilao->recebeLance(new Lance($usuario3, 225.0));
        $leilao->recebeLance(new Lance($usuario2, 310));
        $leilao->recebeLance(new Lance($usuario1, 355));

        return [
            "ordem_crescente" => [$leilao]
        ];
    }

    public static function criaLeilaoEmOrdemDecrescente()
    {
        $leilao = new Leilao('Xtz 125 2008');
        $usuario1 = new Usuario("thiago");
        $usuario2 = new Usuario('beatriz');
        $usuario3 = new Usuario('walter');

        $leilao->recebeLance(new Lance($usuario1, 355));
        $leilao->recebeLance(new Lance($usuario3, 310));
        $leilao->recebeLance(new Lance($usuario2, 225.0));
        $leilao->recebeLance(new Lance($usuario3, 140));
        $leilao->recebeLance(new Lance($usuario2, 139.22));
        $leilao->recebeLance(new Lance($usuario1, 170));
        $leilao->recebeLance(new Lance($usuario3, 100));
        $leilao->recebeLance(new Lance($usuario2, 50));
        
        return [
            "ordem_decrescente" => [$leilao]
        ];
    }

    public static function criaLeilaoEmOrdemAleatoria()
    {
        $leilao = new Leilao('Xtz 125 2008');
        $usuario1 = new Usuario("thiago");
        $usuario2 = new Usuario('beatriz');
        $usuario3 = new Usuario('walter');

        $leilao->recebeLance(new Lance($usuario1, 170));
        $leilao->recebeLance(new Lance($usuario3, 50));
        $leilao->recebeLance(new Lance($usuario1, 225));
        $leilao->recebeLance(new Lance($usuario3, 140));
        $leilao->recebeLance(new Lance($usuario2, 139.22));
        $leilao->recebeLance(new Lance($usuario1, 355));
        $leilao->recebeLance(new Lance($usuario3, 100));
        $leilao->recebeLance(new Lance($usuario2, 310));
        
        return [
            "ordem_aleatoria" => [$leilao]
        ];
    }


}