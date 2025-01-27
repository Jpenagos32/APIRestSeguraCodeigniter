<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model {
  protected $table = 'user';
  protected $primaryKey = 'id';
  protected $allowedFields = [
    'name', 'email', 'password'
  ];
  protected $updatedField = 'updated_at';
  
  //callbacks https://www.codeigniter.com/user_guide/models/model.html#callbacks
  protected $beforeInsert = ['beforeInsert'];
  protected $beforeUpdate = ['beforeUpdate'];
  
  protected function beforeInsert(array $data): array {
    return $this->getUpdatedDataWithHashedPassword($data);
  }
  
  protected function beforeUpdate(array $data): array {
    return $this->getUpdatedDataWithHashedPassword($data);
  }
  
  private function getUpdatedDataWithHashedPassword(array $data): array {
    if (isset($data['data']['password'])) {
      $plainTextPassword = $data['data']['password'];
      $data['data']['password'] = password_hash($plainTextPassword, PASSWORD_DEFAULT);
    }
    return $data;
  }
  
  public function findUserByEmail(string $email): array {
    $user = $this->asarray()->where(['email' => $email])->first();
    
    if (!$user) {
      throw new \Exception('User does not exist for email: ' . $email);
    }
    
    return $user;
  }
}
