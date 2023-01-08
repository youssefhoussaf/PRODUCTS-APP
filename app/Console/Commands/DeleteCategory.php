<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DeleteCategory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:category';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete an category';

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
        $id = $this->ask('Enter category id');

        if(!$id){
            $this->error('You must enter id');
            return 1;
        }

        $category = \App\Models\Category::find($id);

        if(!$category){
            $this->error("Category doesn't exist");
            return 1;
        }

        $category->delete();

        $this->info('Category deleted.');

        return 0;
    }
}
