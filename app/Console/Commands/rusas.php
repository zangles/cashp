<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class rusas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'download:rusas';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start image download from rusas';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $controller = app()->make('App\Http\Controllers\DownloadsController');
        app()->call([$controller, 'rusas'], [ 'log' => true ] );
    }
}
