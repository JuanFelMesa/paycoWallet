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


    public function validarUsuario($correo,$identificacion){
        $em = $this->getEntityManager();
        $usuarioIdentificacion = $em->getRepository('App:Usuario\Usuario')->findBy(array('numeroIdentificacion'=>$identificacion));
        $usuarioCorreo = $em->getRepository('App:Usuario\Usuario')->findBy(array('correo'=>$correo));
        if ($usuarioIdentificacion && $usuarioCorreo){
            return true;
        }
        else {
            return false;
        }
    }


}
