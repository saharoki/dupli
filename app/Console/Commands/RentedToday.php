<?php

namespace App\Console\Commands;

use App\Models\Movies;
use App\Models\Rent;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

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
        $rents = Rent::where('rent_start', '=', date('Y-m-d'))->get();
        $total = 0;
        $text = '';
        foreach ($rents as $rented){
            $text += "Movie: {$rented->movie->name} \n";
            $total++;
        }
        $text += "Total rented: {$total}";

        Mail::mailer('sendmail')->raw($text, function($message) {
            $message->to('example@google.com')->subject('Rented today movies');
            $message->from('test@google.com');
        });
    }
}
