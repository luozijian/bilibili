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
                'password' => '$2y$10$ulJrS6fkmLn/muVvT4FdzuB.TmjvLRL9NjAS3aF68jht1QCDmvRoO',
                'confirmation_token' => 'uSVhA5QAg4tI0h2cWts1o1WPJ4UXFfrQURZEyxDQ',
                'is_active' => 1
            ]
        );
    }
}
