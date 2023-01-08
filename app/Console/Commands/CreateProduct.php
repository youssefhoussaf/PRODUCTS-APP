<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

class CreateProduct extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:product';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'create an new product';

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
        $name = $this->ask('Enter product name');
        $description = $this->ask('Enter product description');
        $price = $this->ask('Enter product price');
        $id_category = $this->ask('Enter category id');

        $data = [
            'name' => $name,
            'description' => $description,
            'price' => $price,
            'id_category' => $id_category,
        ];

        $validator = Validator::make($data, [
            'name' => 'required|string|max:100',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'id_category' => 'required|integer|exists:categories,id',
        ]);

        if ($validator->fails()) {
            $this->info('Product not created. See error messages below:');
        
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }
            return 1;
        }

        \App\Models\Product::create($data);
        
        $this->info('Product created.');
        
        return 0;
    }
}
