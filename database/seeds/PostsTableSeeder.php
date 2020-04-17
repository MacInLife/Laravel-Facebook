<?php

use Illuminate\Database\Seeder;
//Add use Faker
use Faker\Factory as Faker;
use App\Post;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
          //Permet de générer des fausses données 'fr_FR' en français
          $faker = Faker::create('fr_FR');

          //Boucle de création des faux posts
          for ($i = 0; $i < 10; $i++) {
              $post = new Post();
              $post->text = $faker->text();
              $post->user_id = $faker->numberBetween(1, 9);
              $post->save();
          }
    }
}
