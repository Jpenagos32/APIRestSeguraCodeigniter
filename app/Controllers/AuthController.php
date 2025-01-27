<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;

class AuthController extends BaseController {
  public function register() {
    $rules = [
      'name' => 'required',
      'email' => 'required|valid_email|is_unique[user.email]',
      'password' => 'required|min_length[8]|max_length[255]',
    ];
    // Obtener datos que vienen por JSON
    $input = $this->getRequestInput($this->request);
    
    if (!$this->validateRequest($input, $rules)) {
      return $this->getResponse($this->validator->getErrors(), ResponseInterface::HTTP_BAD_REQUEST);
    }
    
    $userModel = new UserModel();
    
    $userModel->save($input);
    
    return $this->getJWTForUser($input['email'], ResponseInterface::HTTP_CREATED);
  }
  
  public function login() {
    $rules = [
      'email' => 'required|valid_email|min_length[6]|max_length[50]',
      'password' => 'required|min_length[8]|max_length[255]|validateUser[email, password]', // validateUser[] es una validacion personalizada
    ];
    
    $errors = [
      'password' => [
        'validateUser' => 'Invalid login credentials',
      ]
    ];
    
    $input = $this->getRequestInput($this->request);
    
    if (!$this->validateRequest($input, $rules, $errors)) {
      return $this->getResponse($this->validator->getErrors(), ResponseInterface::HTTP_BAD_REQUEST);
    }
    
    return $this->getJWTForUser($input['email'], ResponseInterface::HTTP_OK);
  }
  
  private function getJWTForUser(string $email, int $responseCode = ResponseInterface::HTTP_OK) {
    try {
      $userModel = new UserModel();
      $user = $userModel->findUserByEmail($email);
      unset($user['password']);
      
      helper('jwt');
      return $this->getResponse([
        'message' => 'User authenticated successfully',
        'user' => $user,
        'access_token' => getSignedJWTForUser($email)
      ]);
    } catch (\Exception $e) {
      return $this->getResponse([
        'error' => $e->getMessage(),
      ], $responseCode);
    }
  }
}
