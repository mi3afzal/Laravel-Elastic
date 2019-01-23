<?php

use Illuminate\Database\Seeder;
//use App\Article;

class ArticleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
	/*public function run()
    {
        $faker = Faker\Factory::create();

        for($i=0; $i<50; $i++) {
          Article::create([
            'title' => $faker->sentence(3),
            'body' => $faker->paragraph(6),
            'tags' => join(',', $faker->words(4))
          ]);
        }
    }*/
	
	// php artisan make:factory ArticleFactory --model=Article
	
	public function run()
    {
        // Create the Users 
        $users = factory(App\User::class, 10)->create();

        // Create a range of films for each users
        $users->each(function($user){
            factory(App\Article::class, rand(5, 10))->create(['user_id' => $user->id]);
        });


    }

}
