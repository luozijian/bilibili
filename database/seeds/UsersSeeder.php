<?php

use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('users')->delete();

        \DB::table('users')->insert(
            [
                'id' => 1,
                'name' => 'admin',
                'email' => '564774252@qq.com',
                'password' => '$2y$10$t8/tXHa1lvmnRS7QIBkIJOpceqMmmlw30ggtlp7AXjR2JOWgpI53C',
                'confirmation_token' => '8VTZUSwYoOJmNg6wc1t4wVQorp8MZ7ObKfKsDy3a'
            ]
        );
    }
}
