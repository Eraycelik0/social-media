<?php

namespace App\Console\Commands;

use App\Models\Movie;
use Illuminate\Console\Command;

class ImportMovies extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import-movies';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import movies from CSV file';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $filePath = public_path('CSV/Films/tmdb_5000_movies.csv');

        if (file_exists($filePath)) {
            $csvData = array_map('str_getcsv', file($filePath));

            foreach ($csvData as $row) {
                Movie::create([
                    'budget' => $row[0],
                    'genres' => $row[1],
                    'homepage' => $row[2],
                    'id' => $row[3],
                    'keywords' => $row[4],
                    'original_language' => $row[5],
                    'original_title' => $row[6],
                    'overview' => $row[7],
                    'popularity' => $row[8],
                    'production_companies' => $row[9],
                    'production_countries' => $row[10],
                    'release_date' => $row[11],
                    'revenue' => $row[12],
                    'runtime' => $row[13],
                    'spoken_languages' => $row[14],
                    'status' => $row[15],
                    'tagline' => $row[16],
                    'title' => $row[17],
                    'vote_average' => $row[18],
                    'vote_count' => $row[19],
                ]);
            }

            $this->info('Movies imported successfully.');
        } else {
            $this->error('CSV file not found.');
        }
    }
}
