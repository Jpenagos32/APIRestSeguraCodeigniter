<?php

namespace App\Models;

use CodeIgniter\Model;

class ClientModel extends Model {
  protected $table = 'client';
  protected $primaryKey = 'id';
  protected $allowedFields = [
    'name', 'email', 'retainer_fee'
  ];
  
  protected $useTimestamps = true;
  protected $updatedField = 'updated_at';
  
  //callbacks https://www.codeigniter.com/user_guide/models/model.html#callbacks
  public function findClientById($id): array {
    $client = $this->asarray()->where(['id' => $id])->first();
    
    if (!$client) {
      throw new \Exception("Client not found for id $id");
    }
    
    return $client;
  }
}
