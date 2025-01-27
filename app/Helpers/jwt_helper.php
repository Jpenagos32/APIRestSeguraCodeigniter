<?php
// Los archivos helper deben nombrarse asi: nombredelhelper_helper.php todo en minusculas
// enlace a la documentacion de helpers: https://www.codeigniter.com/user_guide/general/helpers.html#
use App\Models\UserModel;
use Firebase\JWT\JWT;

// FUNCIONES NECESARIAS PARA AUTENTICACION CON JWT

/**
 * funcion que permite obtener el token desde la cabecera de la solicitud HTTP desde cualquier endpoint
 *
 * @return string
 * */
function getJWTFromRequest($authHeader): string {
  if (is_null($authHeader)) {
    throw new Exception("Missing or invalid JWT in request");
  }
  
  // Obtener unicamente el token (elimina la palabra "Bearer "
  return explode(" ", $authHeader)[1];
}

/**
 * Funcion que valida el JWT firmado
 *
 * @return void
 * */
function validateJWTFromRequest(string $encodedToken): void {
  //$key = getenv('JWT_SECRET_KEY');
  $key = \Config\Services::getSecretKey();
  $decodedToken = JWT::decode($encodedToken, $key, ['HS256']);
  
  $userModel = new UserModel();
  $userModel->findUserByEmail($decodedToken->email);
}

/**
 * Funcion que ayuda a devolver un token firmado
 *
 */
function getSignedJWTForUser(string $email): string {
  // fecha de emisión del token
  $issuedAtTime = time();
  
  // tiempo de vida del token
  $tokenTimeToLive = getenv('JWT_TIME_TO_LIVE');
  
  // tiempo de expiración del token
  $tokenExpiration = $issuedAtTime + $tokenTimeToLive;
  
  //payload del JWT
  $payload = [
    'email' => $email,
    'iat' => $issuedAtTime,
    'exp' => $tokenExpiration
  ];
  
  $jwt = JWT::encode($payload, \Config\Services::getSecretKey());
  
  return $jwt;
}