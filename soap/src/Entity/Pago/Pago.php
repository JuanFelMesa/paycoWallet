<?php

namespace App\Entity\Pago;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass="App\Repository\Pago\PagoRepository")
 */
class Pago
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="codigo_pago_pk",type="integer", unique=true)
     */
    private $codigoPagoPk;

    /**
     * @ORM\Column(name="token", type="text", nullable=false)
     */
    private $token;

    /**
     * @ORM\Column(name="codigo_billetera_fk", type="integer", nullable=false)
     */
    private $codigoBilleteraFk;

    /**
     * @ORM\Column(name="valor", type="integer", nullable=false)
     */
    private $valor;

    /**
     * @ORM\Column(name="confirmado", type="boolean", nullable=false)
     */
    private $confirmado = false;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Billetera\Billetera", inversedBy="pagoRel")
     * @ORM\JoinColumn(name="codigo_billetera_fk", referencedColumnName="codigo_billetera_pk")
     */
    private $billeteraRel;

    /**
     * @return mixed
     */
    public function getCodigoPagoPk()
    {
        return $this->codigoPagoPk;
    }

    /**
     * @param mixed $codigoPagoPk
     */
    public function setCodigoPagoPk($codigoPagoPk): void
    {
        $this->codigoPagoPk = $codigoPagoPk;
    }

    /**
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param mixed $token
     */
    public function setToken($token): void
    {
        $this->token = $token;
    }

    /**
     * @return mixed
     */
    public function getCodigoBilleteraFk()
    {
        return $this->codigoBilleteraFk;
    }

    /**
     * @param mixed $codigoBilleteraFk
     */
    public function setCodigoBilleteraFk($codigoBilleteraFk): void
    {
        $this->codigoBilleteraFk = $codigoBilleteraFk;
    }

    /**
     * @return mixed
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * @param mixed $valor
     */
    public function setValor($valor): void
    {
        $this->valor = $valor;
    }

    /**
     * @return mixed
     */
    public function getConfirmado()
    {
        return $this->confirmado;
    }

    /**
     * @param mixed $confirmado
     */
    public function setConfirmado($confirmado): void
    {
        $this->confirmado = $confirmado;
    }

    /**
     * @return mixed
     */
    public function getBilleteraRel()
    {
        return $this->billeteraRel;
    }

    /**
     * @param mixed $billeteraRel
     */
    public function setBilleteraRel($billeteraRel): void
    {
        $this->billeteraRel = $billeteraRel;
    }


}
