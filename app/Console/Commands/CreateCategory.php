<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

class CreateCategory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:category';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new category';

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
        $name = $this->ask('Enter category name');
        $category_parent = $this->ask('Enter parent category id (not required)');

        $data = [
            'name' => $name,
            'category_parent' => $category_parent,
        ];

        $validator = Validator::make($data, [
            'name' => 'required|string|max:100',
            'category_parent' => 'nullable|integer|exists:categories',
        ]);

        if ($validator->fails()) {
            $this->info('Category not created. See error messages below:');
        
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }
            return 1;
        }

        \App\Models\Category::create($data);
        
        $this->info('Category created.');
        
        return 0;

    }
}
