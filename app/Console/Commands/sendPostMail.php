<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Artisan;
use App\Http\Controllers\PostController;
class sendPostMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:post-email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send post mails to all users';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $controller = new PostController(); 
        $controller->sendEmail();
        Artisan::call('queue:work');
       
        return 'sent';
    }
}
