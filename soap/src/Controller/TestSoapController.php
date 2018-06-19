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
        $client = new nusoap_client('http://soap.payco.com/index.php/billetera/soap?wsdl', 'wsdl');
        $client->setEndpoint('http://soap.payco.com/index.php/billetera/soap');

        $client->decode_utf8 = true;

        // Calls
        $result = $client->call('recargarbilletera', array(


            'celular'=>'3185668227',
            'numeroIdentificacion' => '15371377',
            'valor'=>  10000,


        ));


        return new Response($client->responseData);
    }
}