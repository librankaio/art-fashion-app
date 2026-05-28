<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\MitemExistTransService;
use App\Models\Mitem;

class FixExistTrans extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mitem:fix-exist-trans';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Recheck and fix exist_trans flag for all Mitem records';

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
     * @return int
     */
    public function handle()
    {
        $count = Mitem::count();
        $this->info("Rechecking exist_trans for {$count} items...");
        $bar = $this->output->createProgressBar($count);
        $bar->start();

        Mitem::pluck('code')->each(function ($kode) use ($bar) {
            MitemExistTransService::recheck($kode);
            $bar->advance();
        });

        $bar->finish();
        $this->newLine();
        $this->info('Done! exist_trans flag has been updated for all items.');

        return 0;
    }
}
