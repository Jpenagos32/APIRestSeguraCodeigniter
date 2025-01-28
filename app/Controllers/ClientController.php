<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ClientModel;
use CodeIgniter\HTTP\ResponseInterface;

class ClientController extends BaseController {
  public function index() {
    $model = new ClientModel();
    return $this->getResponse([
      'message' => 'Clients retrieved successfully',
      'clients' => $model->findAll()
    ]);
  }
  
  public function store() {
    $rules = [
      'name' => 'required',
      'email' => 'required|valid_email|min_length[5]|max_length[255]|is_unique[client.email]',
      'retainer_fee' => 'required|max_length[255]',
    ];
    
    $input = $this->getRequestInput($this->request);
    
    if (!$this->validateRequest($input, $rules)) {
      return $this->getResponse($this->validator->getErrors(), ResponseInterface::HTTP_BAD_REQUEST);
    }
    
    $clientEmail = $input['email'];
    
    $model = new ClientModel();
    $model->save($input);
    
    $client = $model->where('email', $clientEmail)->first();
    
    return $this->getResponse([
      'message' => 'Client created successfully',
      'client' => $client
    ]);
  }
  
  public function show($id) {
    try {
      $model = new ClientModel();
      $client = $model->findClientById($id);
      
      return $this->getResponse([
        'message' => 'Client retrieved successfully',
        'client' => $client
      ]);
      
    } catch (\Exception $e) {
      return $this->getResponse([
        'message' => 'Could not retrieve client information',
      ], ResponseInterface::HTTP_NOT_FOUND);
    }
  }
  
  public function update($id) {
    try {
      $model = new ClientModel();
      $model->findClientById($id);
      
      $input = $this->getRequestInput($this->request);
      
      $model->update($id, $input);
      $client = $model->findClientById($id);
      
      return $this->getResponse([
        'message' => 'Client updated successfully',
        'client' => $client
      ]);
      
    } catch (\Exception $e) {
      return $this->getResponse([
        'message' => $e->getMessage(),
      ], ResponseInterface::HTTP_NOT_FOUND);
    }
  }
  
  public function destroy($id) {
    try {
      $model = new ClientModel();
      $client = $model->findClientById($id);
      $model->delete($id);
      
      return $this->getResponse([
        'message' => 'Client deleted successfully',
      ]);
    } catch (\Exception $e) {
      return $this->getResponse([
        'message' => $e->getMessage(),
      ], ResponseInterface::HTTP_NOT_FOUND);
    }
  }
}
