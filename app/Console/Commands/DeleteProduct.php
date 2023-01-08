<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DeleteProduct extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:product';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete an product';

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
        $id = $this->ask('Enter product id');

        if(!$id){
            $this->error('You must enter id');
            return 1;
        }

        $product = \App\Models\Product::find($id);

        if(!$product){
            $this->error("Product doesn't exist");
            return 1;
        }

        $product->delete();

        $this->info('Product deleted.');

        return 0;
    }
}
