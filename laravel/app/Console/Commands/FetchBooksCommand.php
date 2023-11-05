<?php

namespace App\Console\Commands;

use App\Jobs\FetchBooksJob;
use Illuminate\Console\Command;

class FetchBooksCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:books';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch books from Google Books API and store them in the database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        dispatch(new FetchBooksJob());
    }
}
