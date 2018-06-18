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
        $client = new nusoap_client('http://soap.payco.com/index.php/usuario/soap?wsdl', 'wsdl');
        $client->setEndpoint('http://soap.payco.com/index.php/usuario/soap');

        $client->decode_utf8 = true;

        // Calls
        $result = $client->call('crearusuario', array(
            'nombre'=>  'Juan David Marulanda V.',
            'correo' => 'juandavidmarulanda@yahoo.com',
            'numeroIdentificacion' => '15371377',
            'celular'=>'3185668227'


        ));


        return $result;
    }
}