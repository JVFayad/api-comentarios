<?php

use Illuminate\Database\Seeder;

class UsersSeed extends Seeder
{
    /**
     * Cria usuário de teste
     *
     * @return void
     */
    public function run()
    {
        App\User::create([
            'name' => 'Joao Teste',
            'email' => 'joao.teste@gmail.com',
            'password' => bcrypt('senha'),
            'login' => 'joao_teste',
            'subscriber' => TRUE,
            'cash' => 100.0
        ]);

        App\User::create([
            'name' => 'Pedro Teste',
            'email' => 'pedro.teste@gmail.com',
            'password' => bcrypt('senha'),
            'login' => 'pedro_teste',
            'subscriber' => FALSE,
            'cash' => 10.0
        ]);
    }
}
