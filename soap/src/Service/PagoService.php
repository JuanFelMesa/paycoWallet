<?php

namespace App\Service;


use App\Entity\Usuario\Usuario;
use App\Entity\Pago\Pago;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Config\Definition\Exception\Exception;



class PagoService
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    public function realizarPago($identificacion, $valor){
        /**
         * @var Usuario $arUsuario
         */


        $response = array('success' => false,
            'cod_error' => '',
            'message_error' => '');
        if($identificacion != null && $valor != null){

            try{

                $validarIdentificacion =$this->em->getRepository('App:Usuario\Usuario')->validaUsuarioIdentificacion($identificacion);

                if($validarIdentificacion ){

                    $arUsuario  = $this->em->getRepository('App:Usuario\Usuario')->findBy(array('numeroIdentificacion'=>$identificacion));

                    $arBilletera  = $this->em->getRepository("App:Billetera\Billetera")->findBy(array('codigoUsuarioFk'=>$arUsuario[0]->getCodigoUsuarioPk()));

                    $arPago = new Pago();
                    $token = $this->generarToken();
                    $arPago->setBilleteraRel($arBilletera[0]);
                    $arPago->setValor($valor);
                    $arPago->setConfirmado(false);
                    $arPago->setToken($token);
                    $this->em->persist($arPago);
                    $this->em->flush();
//                    $message = ( new \Swift_Message( 'Token de confirmacion de compra' ) )
//                        ->setFrom( 'paycowallet@gmail.com' )
//                        ->setTo( $arUsuario[0]->getCorreo() )
//                        ->setBody(
//                            $token,
//                            'text/html'
//                        );
//                    $mailer->send( $message );
                    $response['success'] = true;
                    $response['data'] = 'Se ha generado correctamente el pago por favor validar con el token enviado a su correo y su numero de identificacion';

                }else{
                    $response['success'] = false;
                    $response['cod_error'] = 416;
                    $response['message_error'] = 'El numero de identificacion no existe';
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

    public function confirmarPago($identificacion, $token){
        $response = array('success' => false,
            'cod_error' => '',
            'message_error' => '');
        if($identificacion != null){
            try{
                $validarIdentificacion =$this->em->getRepository('App:Usuario\Usuario')->validaUsuarioIdentificacion($identificacion);
                if($validarIdentificacion){
                    $arUsuario  = $this->em->getRepository('App:Usuario\Usuario')->findBy(array('numeroIdentificacion'=>$identificacion));

                    $arBilletera  = $this->em->getRepository("App:Billetera\Billetera")->findBy(array('codigoUsuarioFk'=>$arUsuario[0]->getCodigoUsuarioPk()));

                    $arPago =  $this->em->getRepository("App:Pago\Pago")->findBy(array('codigoBilleteraFk'=>$arBilletera[0]->getCodigoBilleteraPk()));
                    $valorPago = $arPago->getValor();
                    if($arPago->getToken() == $token){
                        if(($arBilletera[0]->getSaldo() - $valorPago ) < 0){
                            $response['success'] = false;
                            $response['cod_error'] = 417;
                            $response['message_error'] = 'No se puede pagar, saldo insuficiente';
                        }else{
                            $saldoActual = $arBilletera[0]->getSaldo();
                            $saldoActual -= $valorPago;
                            $arBilletera->setSaldo($saldoActual);
                            $this->em->persist($arBilletera);
                            $this->em->flush();
                            $response['success'] = true;
                            $response['cod_error'] = '';
                            $response['message_error'] = 'Se ha realizado el pago correctamente.';
                        }
                    } else{
                        $response['success'] = false;
                        $response['cod_error'] = 417;
                        $response['message_error'] = 'No se pudo confirmar el pago, el token no coincide';
                    }

                }else{
                    $response['success'] = false;
                    $response['cod_error'] = 417;
                    $response['message_error'] = 'No se pudo confirmar el pago';
                }
            } catch (Exception $e){
            $response['success'] = false;
            $response['cod_error'] = $e->getCode();
            $response['message_error'] = $e->getMessage();
            }
        }
   }

    private function generarToken(){

        $letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $digits = '1234567890';
        $randomString = '';
        for ($i = 0; $i < 3; $i++) {
            $randomString .= $letters[rand(0, strlen($letters) - 1)];
        }
        for ($i = 0; $i < 3; $i++) {
            $randomString .= $digits[rand(0, strlen($digits) - 1)];
        }

        return $randomString;
    }


}