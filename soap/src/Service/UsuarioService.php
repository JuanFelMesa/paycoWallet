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

    public function crearUsuario($nombre,$celular,$correo,$identificacion)
    {


        $response = array('success' => false,
            'cod_error' => '',
            'message_error' => '');
            if ($nombre != null){
                try{
                    $arUsuario = new Usuario();
                    $arBilletera = new Billetera();

                    if($this->em->getRepository('App:Usuario\Usuario')->validaUsuarioCorreo($correo) || $this->em->getRepository('App:Usuario\Usuario')->validaUsuarioIdentificacion($identificacion) ){
                        $response['success'] = false;
                        $response['cod_error'] = 416;
                        $response['message_error'] = 'Ya existe ese correo o numero de identificacion';
                    } else {
                        $arUsuario->setNombre($nombre);
                        $arUsuario->setCorreo($correo);
                        $arUsuario->setNumeroIdentificacion($identificacion);
                        $arUsuario->setCelular($celular);
                        $this->em->persist($arUsuario);
                        $arBilletera->setUsuarioRel($arUsuario);
                        $arBilletera->setSaldo(0);
                        $this->em->persist($arBilletera);
                        $this->em->flush();
                        $response['success'] = true;
                        $response['data'] = 'Se ha creado el usuario y su billetera satisfactoriamente';

                    }

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

                 return json_encode($response);

    }
}