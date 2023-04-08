<?php

namespace Alura\Leilao\test\model;

use Alura\Leilao\Model\Lance;
use Alura\Leilao\Model\Leilao;
use Alura\Leilao\Model\Usuario;
use PHPUnit\Framework\TestCase;

class LeilaoTest extends TestCase
{

    /**
     * @dataProvider geraLances
     */
    public function teste_Leilao_Deve_Receber_lances(Leilao $leilao)
    {
        self::assertCount(2, $leilao->getLances());
        self::assertEquals(1000 ,$leilao->getLances()[0]->getValor());
        self::assertEquals(2000 ,$leilao->getLances()[1]->getValor());
    }

    /**
     * @dataProvider geraUmLance
     */
    public function teste_Leilao_Deve_Apenas_Um_Lance(Leilao $leilao)
    {
        self::assertCount(1, $leilao->getLances());
        self::assertEquals(1000 ,$leilao->getLances()[0]->getValor());
    }

    /**
     * @dataProvider geraLanceRepetido
     */
    public function test_Leilao_Nao_Deve_Receber_Lances_Repetidos(Leilao $leilao)
    {
        self::assertCount(1, $leilao->getLances());
        self::assertEquals(1000, $leilao->getLances()[0]->getValor());
    }

    /**
     * @dataProvider verificaSeUsuarioDeuMaisDeCincoLances
     */
    public function test_Leilao_Nao_Pode_Receber_Mais_De_Cinco_Lances_Do_Mesmo_Usuario(Leilao $leilao)
    {
        self::assertCount(10, $leilao->getLances());
        self::assertEquals(10000, $leilao->getLances()[count($leilao->getLances()) - 1 ]->getValor());
    }


    /** -------------------  DADOS ------------------------------------------- */
    public static function geraLances()
    {
        $thiago = new Usuario('thiago');
        $walter = new Usuario('walter');
        $leilao = new Leilao('Fiat 147 0km');

        $leilao->recebeLance(new Lance($thiago, 1000));
        $leilao->recebeLance(new Lance($walter, 2000));

        return [
            "mais de um lance" => [$leilao]
        ];
    }

    public static function geraUmLance()
    {
        $thiago = new Usuario('thiago');
        $leilao = new Leilao('Fiat 147 0km');

        $leilao->recebeLance(new Lance($thiago, 1000));

        return [
            "Apenas um lance" => [$leilao]
        ];
    }

    public static function geraLanceRepetido()
    {
        $thiago = new Usuario('thiago');
        $leilao = new Leilao('Fiat 147 0km');

        $leilao->recebeLance(new Lance($thiago, 1000));
        $leilao->recebeLance(new Lance($thiago, 2000));

        return [
            "Lance Repetido" => [$leilao]
        ];
    }

    public static function verificaSeUsuarioDeuMaisDeCincoLances()
    {
        $thiago = new Usuario('thiago');
        $walter = new Usuario('walter');

        $leilao = new Leilao('Fiat 147 0km');

        $leilao->recebeLance(new Lance($thiago, 1000));
        $leilao->recebeLance(new Lance($walter, 2000));
        $leilao->recebeLance(new Lance($thiago, 3000));
        $leilao->recebeLance(new Lance($walter, 4000));
        $leilao->recebeLance(new Lance($thiago, 5000));
        $leilao->recebeLance(new Lance($walter, 6000));
        $leilao->recebeLance(new Lance($thiago, 7000));
        $leilao->recebeLance(new Lance($walter, 8000));
        $leilao->recebeLance(new Lance($thiago, 9000));
        $leilao->recebeLance(new Lance($walter, 10000));
        $leilao->recebeLance(new Lance($thiago, 11000));

        return [
            "mais de 5 lances" => [$leilao]
        ];
    }
}