<?php

namespace App\Console\Commands;

use App\Models\Movies;
use App\Models\Rent;
use Illuminate\Console\Command;

class RentedToday extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:rented-today';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Today rented movies';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $rents = Rent::where('rent_start', '=', date('Y-m-d'));
        $total = count($rents);
        foreach ($rents as $rented){
            $this->info("Movie: {$rented->movie->name}");
        }
        $this->info("Total rented: {$total}");
    }
}
