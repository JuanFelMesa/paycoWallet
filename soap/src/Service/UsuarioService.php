<?php

namespace App\Service;

use App\Entity\Usuario\Usuario;
use App\Entity\Billetera\Billetera;
use Doctrine\ORM\EntityManagerInterface;

class UsuarioService
{


    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    public function crearUsuario($params)
    {


        $response = array('success' => false,
            'cod_error' => '',
            'message_error' => '');
            if ($params != null){
                try{
                    $arUsuario = new Usuario();
                    $arBilletera = new Billetera();
                    $arUsuario->setNombre($params['nombre']);
                    $arUsuario->setCorreo($params['correo']);
                    $arUsuario->setNumeroIdentificacion($params['numeroIdentificacion']);
                    $arUsuario->setCelular($params['celular']);
                    $this->em->persist($arUsuario);
                    $arBilletera->setUsuarioRel($arUsuario);
                    $arBilletera->setSaldo(0);
                    $this->em->persist($arBilletera);
                    $this->em->flush();
                    $response['success'] = true;
                }
                catch (\Exception $e){
                    $response['success'] = false;
                    $response['cod_error'] = $e->getCode();
                    $response['message_error'] = $e->getMessage();
                }

            } else{
                $response['success'] = false;
                $response['message_error'] = 'No se han enviado parámetros';
                $response['cod_error'] = 415;
             }

             return $response;

    }
}