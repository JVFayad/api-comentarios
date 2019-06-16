<?php

use Illuminate\Database\Seeder;

class PostsSeed extends Seeder
{
    /**
     * Cria postagem de teste
     *
     * @return void
     */
    public function run()
    {
        App\Post::create([
            'content' => 'Postagem de testes.',
            'type' => 'text',
            'user_id' => 1,
        ]);
    }
}
