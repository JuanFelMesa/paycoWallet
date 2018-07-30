<?php

namespace App\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Service\PagoService;



class PagoController extends Controller
{
    /**
     * @Route("/pago/soap/pagar",name="pagar")
     */
    public function realizarPago(Request $request,PagoService $pagoService)
    {

        $soapServer = new \SoapServer($this->get('kernel')->getProjectDir().'/public/wsdl/realizarpago.wsdl');

        $soapServer->setObject($pagoService);

        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml:text/xml; charset=UTF-8');

        ob_start();
        $soapServer->handle();

        $response->setContent(ob_get_clean());

        return $response;

    }
    /**
     * @Route("/pago/soap/confirmar",name="pagoConfirmar")
     */
    public function confirmarPago(Request $request,PagoService $pagoService)
    {

        $soapServer = new \SoapServer('http://'.$_SERVER['HTTP_HOST'].'/wsdl/confirmarpago.wsdl');

        $soapServer->setObject($pagoService);

        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml:text/xml; charset=UTF-8');

        ob_start();
        $soapServer->handle();

        $response->setContent(ob_get_clean());

        return $response;

    }



}