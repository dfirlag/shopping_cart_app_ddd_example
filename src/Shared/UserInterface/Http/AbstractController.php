<?php

declare(strict_types=1);

namespace App\Shared\UserInterface\Http;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class AbstractController
 *
 * @package App\Shared\UserInterface\Http
 */
class AbstractController {

    /**
     * @param string $message
     * @return Response
     */
    public function getErrorJsonResponse(string $message): Response {
        $response = new JsonResponse();
        $response->setStatusCode(Response::HTTP_BAD_REQUEST);
        $response->setJson(json_encode(['error' => $message]));
        return $response;
    }

    /**
     * @return Response
     */
    public function getOkJsonResponse(): Response {
        $response =  new JsonResponse();
        $response->setStatusCode(Response::HTTP_OK);
        return $response;
    }
}