<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Faker $faker): void
    {
        for ($i = 0; $i < 9; $i++) {
            $project = new Project();
            $project->title = $faker->realtext(50);
            $project->cover_image = $faker->imageUrl();
            $project->slug = Str::slug($project->title, '-');
            $project->content = $faker->realtext(50);
            $project->github = 'https://github.com';
            $project->website = $faker->url();
            $project->save();
        }
    }
}
