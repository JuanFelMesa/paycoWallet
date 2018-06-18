<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use nusoap_client;


class TestSoapController extends Controller
{
    /**
     * @Route("/test",name="testSoap")
     */

    public function test(Request $request){

        // Config
        $client = new nusoap_client('http://soap.payco.com/index.php/usuario/soap/crear?wsdl', 'wsdl');
        $client->setEndpoint('http://soap.payco.com/index.php/usuario/soap/crear');
//        $client->soap_defencoding = 'ISO-8859-1';
        $client->decode_utf8 = true;
//        $client->debug();
//        echo '<pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
//        echo '<h2>Response</h2>';
//        echo '<pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';


        // Calls
        $result = $client->call('crearusuario', array(
            'nombre'=>  'Juan David Marulanda V.',
            'correo' => 'juandavidmarulanda@yahoo.com',
            'numeroIdentificacion' => '15371377',
            'celular'=>'3185668227'


        ));

//
//
//
//
//
//
//        $soapClient = new \SoapClient('http://soap.payco.com/index.php/usuario/soap?wsdl');
//        $soapClient->setEndpoint('http://soap.payco.com/index.php/usuario/soap');
//
//        $result = $soapClient->crearusuario(json_encode( array(
//            'nombre'=>  'Juan David Marulanda V.',
//            'correo' => 'juandavidmarulanda@yahoo.com',
//            'numeroIdentificacion' => '15371377',
//            'celular'=>'3185668227'


//        )));
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml; charset=UTF-8');
//
//        ob_start();
//
//
        $response->setContent($result);
        return $response;
    }
}