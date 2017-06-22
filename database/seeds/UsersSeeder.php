<?php

use Carbon\Carbon;
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

        \DB::table('users')->insert([
            [
                'id' => 1,
                'name' => 'admin',
                'email' => '564774252@qq.com',
                'password' => '$2y$10$ulJrS6fkmLn/muVvT4FdzuB.TmjvLRL9NjAS3aF68jht1QCDmvRoO',
                'confirmation_token' => 'uSVhA5QAg4tI0h2cWts1o1WPJ4UXFfrQURZEyxDQ',
                'is_active' => 1,
                'api_token' => 'CNFD5xnRR85Y7WB6oJjWqnHlMbn8kDOp9yhIqlovJcZycM3j1UR89pFNJ6gu',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 2,
                'name' => '罗子健',
                'email' => '123123@qq.com',
                'password' => '$2y$10$ulJrS6fkmLn/muVvT4FdzuB.TmjvLRL9NjAS3aF68jht1QCDmvRoO',
                'confirmation_token' => 'uSVhA5QAg4tI0h2cWts1o1WPJ4UXFfrQURZEyxDj',
                'is_active' => 1,
                'api_token' => 'HYdtIySps657lDqdIJ3Haqkja5X8nv3Jp6vVVhe3FAGJlGBpPbn6iZzgo8x4',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 3,
                'name' => '曾志平',
                'email' => '123321@qq.com',
                'password' => '$2y$10$ulJrS6fkmLn/muVvT4FdzuB.TmjvLRL9NjAS3aF68jht1QCDmvRoO',
                'confirmation_token' => 'uSVhA5QAg4tI0h2cWts1o1WPJ4UXFfrQURKEyxDQ',
                'is_active' => 1,
                'api_token' => 'gxQ6WbNu5UTcsNtRZa10XCRFowwE8E1CpXSwFVUoMJxFrUwdjQNSej5DMqFT',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}
