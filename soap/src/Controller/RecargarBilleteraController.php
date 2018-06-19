<?php

namespace App\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Service\BilleteraService;



class RecargarBilleteraController extends Controller
{
    /**
     * @Route("/billetera/soap/recargar",name="billeteraRecargar")
     */
    public function recargarBilletera(Request $request,BilleteraService $billeteraService)
    {

        $soapServer = new \SoapServer('http://soap.payco.com/wsdl/billetera.wsdl');

        $soapServer->setObject($billeteraService);

        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml:text/xml; charset=UTF-8');

        ob_start();
        $soapServer->handle();

        $response->setContent(ob_get_clean());

        return $response;

    }
    /**
     * @Route("/billetera/soap/consultar",name="billeteraConsultar")
     */
    public function consultarBilletera(Request $request,BilleteraService $billeteraService)
    {

        $soapServer = new \SoapServer('http://soap.payco.com/wsdl/consultarbilletera.wsdl');

        $soapServer->setObject($billeteraService);

        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml:text/xml; charset=UTF-8');

        ob_start();
        $soapServer->handle();

        $response->setContent(ob_get_clean());

        return $response;

    }



}