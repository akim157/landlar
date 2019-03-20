<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PortfoliosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('portfolios')->insert([
            [
                'name'      => 'Finance App',
                'images'    => 'portfolio_pic2.jpg',
                'filter'    => 'GPS'
            ],
            [
                'name'      => 'Concept',
                'images'    => 'portfolio_pic3.jpg',
                'filter'    => 'design'
            ],
            [
                'name'      => 'Shopping',
                'images'    => 'portfolio_pic4.jpg',
                'filter'    => 'android'
            ],
            [
                'name'      => 'Managment',
                'images'    => 'portfolio_pic5.jpg',
                'filter'    => 'design'
            ],
            [
                'name'      => 'iPhone',
                'images'    => 'portfolio_pic6.jpg',
                'filter'    => 'web'
            ],
            [
                'name'      => 'Phone',
                'images'    => 'portfolio_pic7.jpg',
                'filter'    => 'web'
            ],
            [
                'name'      => 'Android',
                'images'    => 'portfolio_pic8.jpg',
                'filter'    => 'android'
            ]
        ]);
    }
}
