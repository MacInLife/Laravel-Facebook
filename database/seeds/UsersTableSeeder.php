<?php

use Illuminate\Database\Seeder;
//Add use Faker
use Faker\Factory as Faker;
use App\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // //Permet de générer des fausses données 'fr_FR' en français
        $faker = Faker::create('fr_FR');

        //Boucle de création des faux users
        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->name = $faker->name();
            $user->firstname = $faker->firstName();
            $user->pseudo = $faker->userName();
            $user->email = $faker->email();
            $user->password = Hash::make("azertyuiop");
           // $user->password = Hash::make($faker->password());
            $user->save();
        }
    }
}
