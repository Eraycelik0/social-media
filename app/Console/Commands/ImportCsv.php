<?php

namespace App\Console\Commands;

use App\Models\Book;
use Illuminate\Console\Command;

class ImportCsv extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:csv';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import books from csv file';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $filePath = public_path('/CSV/Books/Books.csv');

        if (file_exists($filePath)) {
            $csvData = array_map('str_getcsv', file($filePath));

            $header = array_shift($csvData);

            foreach ($csvData as $row) {
                $book = new Book();

                $book->title = isset($row[1]) ? $row[1] : null;
                $book->description = null;
                $book->authors = isset($row[2]) ? $row[2] : null;
                $book->publisher = isset($row[4]) ? $row[4] : null;
                $book->imageLinks = isset($row[7]) ? $row[7] : null;
                $book->language = null;
                $book->published_date = isset($row[3]) ? $row[3] : null;

                $book->save();
            }
            $this->info('Books imported successfully.');
        } else {
            $this->error('CSV file not found.');
        }

    }
}
