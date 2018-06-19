<?php

namespace App\Service;


use App\Entity\Usuario\Usuario;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Config\Definition\Exception\Exception;



class BilleteraService
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    public function recargarBilletera($identificacion,$celular,$valor){
        /**
         * @var Usuario $arUsuario
         */

        $response = array('success' => false,
            'cod_error' => '',
            'message_error' => '');
        if($identificacion != null && $celular != null && $valor!= null){
            try{

                $validarIdentificacion =$this->em->getRepository('App:Usuario\Usuario')->validaUsuarioIdentificacion($identificacion);
                $validarCelular =$this->em->getRepository('App:Usuario\Usuario')->validaUsuarioCelular($celular);
                if($validarIdentificacion && $validarCelular){

                    $arUsuario  = $this->em->getRepository('App:Usuario\Usuario')->findBy(array('numeroIdentificacion'=>$identificacion));

                    $arBilletera  = $this->em->getRepository("App:Billetera\Billetera")->findBy(array('codigoUsuarioFk'=>$arUsuario[0]->getCodigoUsuarioPk()));
                    $saldoActual = $arBilletera[0]->getSaldo();
                    $saldoFinal = (integer)$saldoActual + (integer)$valor;
                    $arBilletera[0]->setSaldo($saldoFinal);
                    $this->em->persist($arBilletera[0]);
                    $this->em->flush();
                    $response['success'] = true;
                    $response['data'] = 'Se ha recargado la billetera satisfactoriamente, el nuevo saldo es '. $arBilletera[0]->getSaldo();

                }
            } catch (Exception $e){
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

    public function consultarBilletera($identificacion,$celular){
        $response = array('success' => false,
            'cod_error' => '',
            'message_error' => '');
        if($identificacion != null && $celular != null){
            try{
                $validarIdentificacion =$this->em->getRepository('App:Usuario\Usuario')->validaUsuarioIdentificacion($identificacion);
                $validarCelular =$this->em->getRepository('App:Usuario\Usuario')->validaUsuarioCelular($celular);
                if($validarIdentificacion && $validarCelular){
                    $arUsuario =   $arUsuario  = $this->em->getRepository('App:Usuario\Usuario')->findBy(array('numeroIdentificacion'=>$identificacion));
                    $saldo = $arUsuario[0]->getBilleteraRel()->getSaldo();
                    $response['success'] = true;
                    $response['cod_error'] = '';
                    $response['message_error'] = '';
                    $response['data'] = $saldo;
                } else{
                    $response['success'] = false;
                    $response['cod_error'] = 416;
                    $response['message_error'] = 'El numero de celular o identificacion no coincide';
                }
            }catch (Exception $e){
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