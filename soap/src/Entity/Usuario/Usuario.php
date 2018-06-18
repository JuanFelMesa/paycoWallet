<?php

namespace App\Entity\Usuario;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass="App\Repository\Usuario\UsuarioRepository")
 */
class Usuario
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="codigo_usuario_pk",type="integer", unique=true)
     */
    private $codigoUsuarioPk;

    /**
     * @ORM\Column(name="numero_identificacion", type="string", nullable=true, length=25)
     */
    private $numeroIdentificacion;

    /**
     * @ORM\Column(name="nombre", type="string", nullable=false, length=200)
     */
    private $nombre;


    /**
     * @ORM\Column(name="celular", type="string", nullable=false, length=200)
     */
    private $celular;



    /**
     * @ORM\Column(name="correo",type="string", nullable=false, length=80)
     */
    private $correo;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Billetera\Billetera", mappedBy="usuarioRel")
     */
    private $billeteraRel;




    public function getCodigoUsuarioPk()
    {
        return $this->codigoUsuarioPk;
    }

    /**
     * @return mixed
     */
    public function getNumeroIdentificacion()
    {
        return $this->numeroIdentificacion;
    }

    /**
     * @param mixed $numeroIdentificacion
     */
    public function setNumeroIdentificacion($numeroIdentificacion)
    {
        $this->numeroIdentificacion = $numeroIdentificacion;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param mixed $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCelular()
    {
        return $this->celular;
    }

    /**
     * @param mixed $celular
     */
    public function setCelular($celular)
    {
        $this->celular = $celular;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCorreo()
    {
        return $this->correo;
    }

    /**
     * @param mixed $correo
     */
    public function setCorreo($correo)
    {
        $this->correo = $correo;
        return $this;
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
    public function setBilleteraRel($billeteraRel)
    {
        $this->billeteraRel = $billeteraRel;
        return $this;
    }


}
