<?php

namespace App\Controller;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use nusoap_client;
use Symfony\Component\HttpFoundation\JsonResponse;

class ApiPagoController extends FOSRestController {


    /**
     * @Rest\Post("/api/pago/pagar")
     */
    public function realizarPago( Request $request) {

        set_time_limit(0);
        ini_set("memory_limit", -1);

        $client = new nusoap_client('http://'.$_SERVER['HTTP_HOST'].'/index.php/pago/soap/pagar?wsdl', 'wsdl');
        $client->setEndpoint('http://'.$_SERVER['HTTP_HOST'].'/index.php/pago/soap/pagar');

        $client->decode_utf8 = true;



        $response = array( 'success'=>'',
            'cod_error' => '',
            'message_error' =>'',
            'data'=>[]);
        $data = json_decode($request->getContent('data'), true);
        $data = $data['data'];
        if ($data != null){
            // Calls
            $result = $client->call('realizarpago', array(
                'valor' => $data['valor'],
                'numeroIdentificacion' => $data['numeroIdentificacion']

            ));

            $response = json_decode($result);

        } else {
            $response['success'] = false;
            $response[ 'cod_error']=415;
            $response[ 'message_error']='no se ha enviado ningun dato';
        }
        return new JsonResponse($response);
    }


    /**
     * @Rest\Post("/api/pago/confirmar")
     */
    public function confirmarPago( Request $request) {

        set_time_limit(0);
        ini_set("memory_limit", -1);

        $client = new nusoap_client('http://'.$_SERVER['HTTP_HOST'].'/index.php/pago/soap/pagar?wsdl', 'wsdl');
        $client->setEndpoint('http://'.$_SERVER['HTTP_HOST'].'/index.php/pago/soap/pagar');

        $client->decode_utf8 = true;



        $response = array( 'success'=>'',
            'cod_error' => '',
            'message_error' =>'',
            'data'=>[]);
        $data = json_decode($request->getContent('data'), true);
        $data = $data['data'];
        if ($data != null){
            // Calls
            $result = $client->call('confirmarpago', array(
                'token' => $data['token'],
                'numeroIdentificacion' => $data['numeroIdentificacion']

            ));

            $response = json_decode($result);

        } else {
            $response['success'] = false;
            $response[ 'cod_error']=415;
            $response[ 'message_error']='no se ha enviado ningun dato';
        }
        return new JsonResponse($response);
    }





}
