<?php

namespace App\Controller;



use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Esta clase es la base para todos los controladores que deban realizar funciones de RESPONSE EN SOAP. Este controlador
 * provee funciones básicas y utilidades que sirven a cualquier controlador de SOAP.
 * @package App\Controller
 * @author Juan David Marulanda V. <juandavidmarulanda@yahoo.com>
 * @since 1.0.0
 */
class SoapBaseController extends Controller
{


    /**
     * Esta función permite generar la misma respuesta para las peticiones que deban listar.
     * @param $resultados
     * @param $pagina
     * @return array
     */
    protected function generateResponse($params)
    {

        $respuesta = [
            'success' => $params['succes'],
            'cod_error' => $params['codError'],
            'message_error' => $params['messageError'],
            'data' => [$params['data']]
        ];


        return $respuesta;
    }

    /**
     * @param Request $request
     */
    protected function getParameters($request) {
        if($request->getContent() !== "") {
            $params = json_decode($request->getContent(), true);
        }
        return $params;
    }
}