<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Pluralizer;

class deleteCRUD extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:crud {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deletes CRUD, including controller, model, requests, seeder, migration';

    /**
     * Filesystem instance
     * @var Filesystem
     */
    protected $files;

    public function __construct(Filesystem $files)
    {
        parent::__construct();
        $this->files = $files;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = Pluralizer::singular($this->argument('name'));
        $upperCaseName = ucwords($name);
        $upperCaseNamePlural = ucwords(Pluralizer::plural($name));
        $tableizedName = Pluralizer::inflector()->tableize($name);
        $pluralName = Pluralizer::plural($name);
        $pluralNameTableized = Pluralizer::inflector()->tableize($pluralName);
        $camelPluralName = Pluralizer::inflector()->camelize(Pluralizer::plural($name));
        $camelName = Pluralizer::inflector()->camelize($name);

        // Controller
        $filePath = base_path('app\\Http\\Controllers\\Admin') .'\\' .$upperCaseNamePlural . 'Controller.php';
        $this->deleteFile($filePath);

        // Model
        $filePath = base_path('app\\Models') .'\\' .$upperCaseName . '.php';
        $this->deleteFile($filePath);

        // Store Request
        $filePath = base_path('app\\Http\\Requests') .'\\Store' .$upperCaseName . 'Request.php';
        $this->deleteFile($filePath);

        // Update Request
        $filePath = base_path('app\\Http\\Requests') .'\\Update' .$upperCaseName . 'Request.php';
        $this->deleteFile($filePath);

        // Mass Destroy Request
        $filePath = base_path('app\\Http\\Requests') .'\\MassDestroy' .$upperCaseName . 'Request.php';
        $this->deleteFile($filePath);

        // Migration
        $filesArray = $this->files->allFiles(base_path('database\\migrations'));
        $needle = '_create_' . $pluralNameTableized . '_table.php';
        $filePath = '';
        foreach($filesArray as $file) {
            if ($preNeedle = strstr($file->getFilename(), $needle, true)) {
                $filePath = base_path('database\\migrations\\') . $preNeedle . $needle;
            }
        }
        $this->deleteFile($filePath);

        // Seeder
        $filePath = base_path('database\\seeders') .'\\' . $upperCaseNamePlural . 'TableSeeder.php';
        $this->deleteFile($filePath);

        // Create Vue Component
        $filePath = base_path('resources\\js\\Pages') .'\\' . $upperCaseNamePlural . '.vue';
        $this->deleteFile($filePath);

        // De-append to routes (web.php)
        $filePath = base_path('routes') .'\\web.php';
        $remove = "\n\n    // {$upperCaseNamePlural}\n    Route::delete('$pluralNameTableized/destroy', '{$upperCaseNamePlural}Controller@massDestroy')->name('$pluralNameTableized.massDestroy');
    Route::apiResource('$pluralNameTableized', '{$upperCaseNamePlural}Controller');";

        $this->files->put($filePath, str_replace($remove, '', file_get_contents($filePath)));
        $this->info("De-appended to : {$filePath}");


        // De-append to AppLayout.vue
        $filePath = base_path('resources\\js\\Layouts') .'\\AppLayout.vue';
        $remove = "\n    { name: '{$upperCaseNamePlural}', routeName: '{$pluralNameTableized}.index', icon: CollectionIcon, can: ['{$tableizedName}_read']},";

        $this->files->put($filePath, str_replace($remove, '', file_get_contents($filePath)));
        $this->info("De-appended to : {$filePath}");

        // De-append Seeder DatabaseSeeder.php
        $filePath = base_path('database\\seeders') .'\\DatabaseSeeder.php';
        $remove = "\n\n            {$upperCaseNamePlural}TableSeeder::class,";

        $this->files->put($filePath, str_replace($remove, '', file_get_contents($filePath)));
        $this->info("De-appended to : {$filePath}");

        // De-append to PermissionsSeeder
        $filePath = base_path('database\\seeders') .'\\PermissionsTableSeeder.php';
        $remove = "\n            [
                'name' => '{$tableizedName}_create',
            ],            [
                'name' => '{$tableizedName}_read',
            ],            [
                'name' => '{$tableizedName}_update',
            ],            [
                'name' => '{$tableizedName}_delete',
            ],            [
                'name' => '{$tableizedName}_export',
            ],";

        $this->files->put($filePath, str_replace($remove, '', file_get_contents($filePath)));
        $this->info("De-appended to : {$filePath}");

        // finished
        $this->info('');
        $this->info('Command completed.');
    }

    public function deleteFile($filePath)
    {
        if ($this->files->exists($filePath)) {
            $this->files->delete($filePath);
            $this->info("Deleted : {$filePath}");
        } else {
            $this->info("Not deleted : {$filePath} did not exist");
        }
    }

}
