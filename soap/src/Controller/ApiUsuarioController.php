<?php

namespace App\Controller;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use nusoap_client;
use Symfony\Component\HttpFoundation\JsonResponse;

class ApiUsuarioController extends FOSRestController {


    /**
     * @Rest\Post("/api/usuario/crear")
     */
    public function crearusuario( Request $request) {

        set_time_limit(0);
        ini_set("memory_limit", -1);

        $client = new nusoap_client('http://'.$_SERVER['HTTP_HOST'].'/index.php/usuario/soap?wsdl', 'wsdl');
        $client->setEndpoint('http://'.$_SERVER['HTTP_HOST'].'/index.php/usuario/soap');

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
            $result = $client->call('crearusuario', array(
                'nombre'=>  $data['nombre'],
                'celular'=> $data['celular'],
                'correo' => $data['correo'],
                'numeroIdentificacion' => $data['numeroIdentificacion']
            ));

            $response = json_decode($result);

        } else {
            $response['success'] = false;
            $response['cod_error']=415;
            $response['message_error']='no se ha enviado ningun dato';
        }

        return new JsonResponse($response);
    }

}
