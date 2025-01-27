<?php

namespace App\Filters;

use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;
use PHPUnit\Exception;

class JWTAuthFilter implements FilterInterface {
  
  // Permite formatear en JSON todas las respuestas que se vayan a enviar al front
  use ResponseTrait;
  
  /**
   * Agregar el filtro para la autenticación con JWT
   *
   * @param RequestInterface $request
   * @param array|null $arguments
   *
   * @return RequestInterface|ResponseInterface|string|void
   */
  public function before(RequestInterface $request, $arguments = null) {
    // obtiene el header HTTP_AUTHORIZATION
    $authHeader = $request->getServer('HTTP_AUTHORIZATION');
    
    try {
      // cargar el helper creado 'app/Helpers/jwt_helper.php'
      helper('jwt');
      $encodedToken = getJWTFromRequest($authHeader);
      validateJWTFromRequest($encodedToken);
      return $request;
    } catch (\Exception $e) {
      return Services::response()
        ->setJSON(['error' => $e->getMessage()])
        ->setstatusCode(ResponseInterface::HTTP_UNAUTHORIZED);
    }
  }
  
  /**
   * Allows After filters to inspect and modify the response
   * object as needed. This method does not allow any way
   * to stop execution of other after filters, short of
   * throwing an Exception or Error.
   *
   * @param RequestInterface $request
   * @param ResponseInterface $response
   * @param array|null $arguments
   *
   * @return ResponseInterface|void
   */
  public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {
    //
  }
}
