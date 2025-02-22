<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeInertiaPage extends Command
{
    protected $signature = 'make:feature {name}';
    protected $description = 'Create a new Inertia.js page component in js/features/';

    public function handle()
    {
        $name = $this->argument('name');
        $featurePath = resource_path("js/Features/{$name}.vue");

        // Extract the directory and file name
        $directory = dirname($featurePath);
        $fileName = basename($featurePath);

        // Ensure the directory exists
        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        // Check if the Vue file already exists
        if (File::exists($featurePath)) {
            $this->error("The page '{$name}' already exists.");
            return;
        }

        // Create the Vue file content
        $stub = "<template>\n  <div>\n    <h1>{$name} Page</h1>\n  </div>\n</template>\n\n<script setup>\n</script>";

        // Write the Vue file
        File::put($featurePath, $stub);

        $this->info("Page '{$name}' created successfully at {$featurePath}");
    }
}
