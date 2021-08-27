<?php

namespace App\Console\Commands;

use App\Enums\Status;
use App\Models\Order;
use Illuminate\Console\Command;

class OrderCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'order:destroy';

    /**
     * The console command description.
     */
    protected $description = 'Delete rejected orders';

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
     * Delete rejected orders.
     */
    public function handle()
    {
        $orders = Order::ByStatus(Status::CANCEL)->get('id');
        Order::destroy($orders->toArray());

        $this->info('Send mail report to Admin successfully.');
    }
}
