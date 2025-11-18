<?php

namespace Database\Seeders;

use App\Models\Visitor;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class VisitorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // Membuat 50 data dummy
        for ($i = 0; $i < 50; $i++) {
            $date = $faker->dateTimeBetween('-1 month', 'now');

            Visitor::create([
                'tanggal' => $date->format('Y-m-d'),
                'jam' => $faker->time('H:i'),
                'nama' => $faker->name,
                'kategori' => $faker->randomElement(['pelanggan', 'tamu']),
                'tujuan_kunjungan' => $faker->sentence(rand(3, 8)),
                'kontak' => $faker->phoneNumber,
            ]);
        }
    }
}
