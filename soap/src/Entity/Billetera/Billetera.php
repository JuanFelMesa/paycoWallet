<?php

namespace App\Entity\Billetera;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass="App\Repository\Billetera\BilleteraRepository")
 */
class Billetera
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="codigo_billetera_pk",type="integer", unique=true)
     */
    private $codigoBilleteraPk;

    /**
     * @ORM\Column(name="saldo", type="integer", nullable=false)
     */
    private $saldo=0;

    /**
     * @ORM\Column(name="codigo_usuario_fk", type="integer", nullable=false)
     */
    private $codigoUsuarioFk;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Usuario\Usuario", inversedBy="billeteraRel")
     * @ORM\JoinColumn(name="codigo_usuario_fk", referencedColumnName="codigo_usuario_pk")
     */
    private $usuarioRel;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Pago\Pago", mappedBy="billeteraRel")
     */
    private $pagoRel;

    /**
     * @return mixed
     */
    public function getCodigoBilleteraPk()
    {
        return $this->codigoBilleteraPk;
    }

    /**
     * @param mixed $codigoBilleteraPk
     */
    public function setCodigoBilleteraPk($codigoBilleteraPk): void
    {
        $this->codigoBilleteraPk = $codigoBilleteraPk;
    }

    /**
     * @return mixed
     */
    public function getSaldo()
    {
        return $this->saldo;
    }

    /**
     * @param mixed $saldo
     */
    public function setSaldo($saldo): void
    {
        $this->saldo = $saldo;
    }

    /**
     * @return mixed
     */
    public function getCodigoUsuarioFk()
    {
        return $this->codigoUsuarioFk;
    }

    /**
     * @param mixed $codigoUsuarioFk
     */
    public function setCodigoUsuarioFk($codigoUsuarioFk): void
    {
        $this->codigoUsuarioFk = $codigoUsuarioFk;
    }

    /**
     * @return mixed
     */
    public function getUsuarioRel()
    {
        return $this->usuarioRel;
    }

    /**
     * @param mixed $usuarioRel
     */
    public function setUsuarioRel($usuarioRel): void
    {
        $this->usuarioRel = $usuarioRel;
    }

    /**
     * @return mixed
     */
    public function getPagoRel()
    {
        return $this->pagoRel;
    }

    /**
     * @param mixed $pagoRel
     */
    public function setPagoRel($pagoRel): void
    {
        $this->pagoRel = $pagoRel;
    }




}
