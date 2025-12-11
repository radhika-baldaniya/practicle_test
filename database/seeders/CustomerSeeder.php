<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Customer;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = [

            [
                'name'  => 'Radhika Patel',
                'email' => 'radhika.patel@example.com',
                'phone' => '9876543210',
            ],
            [
                'name'  => 'Amit Sharma',
                'email' => 'amit.sharma@example.com',
                'phone' => '9123456780',
            ],
            [
                'name'  => 'Sneha Verma',
                'email' => 'sneha.verma@example.com',
                'phone' => '9988776655',
            ],
            [
                'name'  => 'Jaydeep Joshi',
                'email' => 'jaydeep.joshi@example.com',
                'phone' => '9090909090',
            ],
            [
                'name'  => 'Priya Desai',
                'email' => 'priya.desai@example.com',
                'phone' => '9822334455',
            ],
            [
                'name'  => 'Manish Chauhan',
                'email' => 'manish.chauhan@example.com',
                'phone' => '9900112233',
            ],
            [
                'name'  => 'Pooja Mehta',
                'email' => 'pooja.mehta@example.com',
                'phone' => '9811223344',
            ],
            [
                'name'  => 'Karan Singh',
                'email' => 'karan.singh@example.com',
                'phone' => '9797979797',
            ],
            [
                'name'  => 'Mitali Shah',
                'email' => 'mitali.shah@example.com',
                'phone' => '9876001234',
            ],
            [
                'name'  => 'Harsh Patel',
                'email' => 'harsh.patel@example.com',
                'phone' => '9009009009',
            ],

        ];

        foreach ($customers as $cust) {
            Customer::create($cust);
        }
    }
}
