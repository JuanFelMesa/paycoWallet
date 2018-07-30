<?php

namespace App\Service;


use App\Entity\Usuario\Usuario;
use App\Entity\Pago\Pago;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Config\Definition\Exception\Exception;




class PagoService
{
    public function __construct(EntityManagerInterface $entityManager,\Swift_Mailer $mailer)
    {
        $this->em = $entityManager;
        $this->mailer = $mailer;
    }

    public function realizarPago($identificacion, $valor,$correo){
        /**
         * @var Usuario $arUsuario
         */


        $response = array('success' => false,
            'cod_error' => '',
            'message_error' => '');
        if($identificacion != null && $valor != null && $correo != null){

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

                    $response['success'] = true;
                    $response['data'] = 'Se ha generado correctamente el pago por favor validar con el token enviado a su correo y su numero de identificacion';

                    $this->enviarCorreo($correo,$token);

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
        if($identificacion != null && $token != null){
            try{
                $validarIdentificacion =$this->em->getRepository('App:Usuario\Usuario')->validaUsuarioIdentificacion($identificacion);
                if($validarIdentificacion){
                    $arUsuario  = $this->em->getRepository('App:Usuario\Usuario')->findBy(array('numeroIdentificacion'=>$identificacion));

                    $arBilletera  = $this->em->getRepository("App:Billetera\Billetera")->findBy(array('codigoUsuarioFk'=>$arUsuario[0]->getCodigoUsuarioPk()));

                    $arPago =  $this->em->getRepository("App:Pago\Pago")->findBy(array('token'=>$token));


                    if($arPago){
                        if( $arPago[0]->getToken() == $token){
                            $valorPago = $arPago[0]->getValor();
                            if(($arBilletera[0]->getSaldo() - $valorPago ) < 0){
                                $response['success'] = false;
                                $response['cod_error'] = 417;
                                $response['message_error'] = 'No se puede pagar, saldo insuficiente';
                            } else {
                                if(!$arPago[0]->getConfirmado()){
                                    $arPago[0]->setConfirmado(true);
                                    $valorPago = $arPago[0]->getValor();
                                    $saldoActual = $arBilletera[0]->getSaldo();
                                    $saldoActual -= $valorPago;
                                    $arBilletera[0]->setSaldo($saldoActual);
                                    $this->em->persist($arBilletera[0]);
                                    $this->em->flush();
                                    $response['success'] = true;
                                    $response['cod_error'] = '';
                                    $response['message_error'] = 'Se ha realizado el pago correctamente.';
                                } else {
                                    $response['success'] = false;
                                    $response['cod_error'] = 417;
                                    $response['message_error'] = 'El pago ya se encuentra confirmado';
                                }

                            }

                        }else{
                            $response['success'] = false;
                            $response['cod_error'] = 417;
                            $response['message_error'] = 'No se puede pagar, no coincide el token';
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
        return json_encode($response);
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

    private function enviarCorreo($correo,$token){
            $message = ( new \Swift_Message( 'Token de confirmacion de compra' ) )
            ->setFrom( 'paycowallet@gmail.com' )
            ->setTo( $correo )
            ->setBody(
                $token,
                'text/html'
            );
        $this->mailer->send( $message );
    }
}