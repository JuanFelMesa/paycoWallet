<?php

namespace App\Controller;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use nusoap_client;
use Symfony\Component\HttpFoundation\JsonResponse;

class ApiBilleteraController extends FOSRestController {


    /**
     * @Rest\Post("/api/billetera/recargar")
     */
    public function recargarBilletera( Request $request) {

        set_time_limit(0);
        ini_set("memory_limit", -1);

        $client = new nusoap_client('http://soap.payco.com/index.php/billetera/soap/recargar?wsdl', 'wsdl');
        $client->setEndpoint('http://soap.payco.com/index.php/billetera/soap/recargar');

        $client->decode_utf8 = true;



        $response = array( 'success'=>'',
            'cod_error' => '',
            'message_error' =>'',
            'data'=>[]);
        $em = $this->getDoctrine()->getManager();
        $data = json_decode($request->getContent('data'), true);
        $data = $data['data'];
        if ($data != null){
            // Calls
            $result = $client->call('recargarbilletera', array(
                'numeroIdentificacion' => $data['numeroIdentificacion'],
                'celular'=> $data['celular'],
                'valor'=> $data['valor']

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
     * @Rest\Post("/api/billetera/consultar")
     */
    public function consultarBilletera( Request $request) {

        set_time_limit(0);
        ini_set("memory_limit", -1);

        $client = new nusoap_client('http://soap.payco.com/index.php/billetera/soap/consultar?wsdl', 'wsdl');
        $client->setEndpoint('http://soap.payco.com/index.php/billetera/soap/consultar');

        $client->decode_utf8 = true;



        $response = array( 'success'=>'',
            'cod_error' => '',
            'message_error' =>'',
            'data'=>[]);
        $em = $this->getDoctrine()->getManager();
        $data = json_decode($request->getContent('data'), true);
        $data = $data['data'];
        if ($data != null){
            // Calls
            $result = $client->call('consultarbilletera', array(
                'numeroIdentificacion' => $data['numeroIdentificacion'],
                'celular'=> $data['celular']
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
