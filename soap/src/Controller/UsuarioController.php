<?php

namespace App\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Service\UsuarioService;



class UsuarioController extends Controller
{
    /**
     * @Route("/usuario/soap",name="usuarioSoap")
     */
    public function crearUsuario(Request $request,UsuarioService $usuarioService)
    {

        $soapServer = new \SoapServer($this->get('kernel')->getProjectDir() . '/public/wsdl/usuario.wsdl');

        $soapServer->setObject($usuarioService);

        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml:text/xml; charset=UTF-8');

        ob_start();
        $soapServer->handle();

        $response->setContent(ob_get_clean());

        return $response;

    }
}