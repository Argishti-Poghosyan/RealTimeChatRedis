<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DailyQuote extends Command
{
   
    protected $signature = 'quote:daily';

   
    protected $description = 'Respectively send an exclusive quote to everyone daily via email.';
    
    public function __construct()
    {
        parent::__construct();
    }

    
    public function handle()
    {
        DB::table('chats')->whereDay('created_at','<=',date('d')-1)->whereDay('created_at','>',date('d')-2)->delete();
    }
}
