<?php

use App\Keyword;
use Illuminate\Database\Seeder;

class KeywordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $keywords = ['JavaScript', 'CSS', 'HTML', 'C++', 'Web Design'];

        foreach ($keywords as $keyword) {
            Keyword::create(['term' => $keyword]);
        }
    }
}
