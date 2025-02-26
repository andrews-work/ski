<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeInertiaPage extends Command
{
    protected $signature = 'make:pages {name}';
    protected $description = 'Create a new Inertia.js page component';

    public function handle()
    {
        $name = $this->argument('name');
        $path = resource_path("js/Pages/{$name}.vue");

        if (File::exists($path)) {
            $this->error("The page '{$name}' already exists.");
            return;
        }

        $stub = "<template>\n  <div>\n    <h1>{$name} Page</h1>\n  </div>\n</template>\n\n<script setup>\n</script>";

        File::put($path, $stub);

        $this->info("Page '{$name}' created successfully at {$path}");
    }
}
