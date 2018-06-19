<?php

namespace App\Repository\Usuario;

use App\Entity\Usuario\Usuario;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;



class UsuarioRepository  extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Usuario::class);
    }


    public function validaUsuarioCorreo($correo){
        $em = $this->getEntityManager();

        $usuario = $em->getRepository('App:Usuario\Usuario')->findBy(array('correo'=>$correo));
        if ($usuario){
            return true;
        }
        else {
            return false;
        }
    }

    public function validaUsuarioIdentificacion($identificacion){
        $em = $this->getEntityManager();

        $usuario = $em->getRepository('App:Usuario\Usuario')->findBy(array('numeroIdentificacion'=>$identificacion));
        if ($usuario){
            return true;
        }
        else {
            return false;
        }
    }

    public function validaUsuarioCelular($celular){
        $em = $this->getEntityManager();

        $usuario = $em->getRepository('App:Usuario\Usuario')->findBy(array('celular'=>$celular));
        if ($usuario){
            return true;
        }
        else {
            return false;
        }
    }

    public function encontrarUsuarioPorIdentificacion($id){
        $em = $this->getEntityManager();
        $arUsuario = $em->getRepository('App:Usuario\Usuario')->findBy(array('numeroIdentificacion'=>$id));
        if($arUsuario){
            return $arUsuario;
        } else {
            return false;
        }
    }

}
