<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

// esta clase sirve para poder generar datos ficticios dentro de la base de datos
class ClientSeeder extends Seeder {
  
  // para poder correr este método usamos el comando php spark db:seed <nombreClaseSeeder> (para este caso ClientSeeder)
  public function run() {
    for ($i = 0; $i <= 10; $i++) {
      $this->db->table('client')->insert($this->generateClient());
    }
  }
  
  /*
   * Método utilizado para generar información ficticia para la tabla clientes
   *
   * */
  private function generateClient(): array {
    $faker = \Faker\Factory::create();
    return [
      'name' => $faker->name(),
      'email' => $faker->email,
      'retainer_fee' => random_int(10000, 100000000)
    ];
  }
}
