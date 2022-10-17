<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Pluralizer;

class makeCRUD extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:crud {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates CRUD, including controller, model, requests, seeder, migration';

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

        $variables = [
            'CLASS_NAME_CAPITALIZED' => $upperCaseName,
            'CLASS_NAME_PLURAL_CAPITALIZED' => $upperCaseNamePlural,
            'CLASS_NAME_TABLEIZED' => $tableizedName,
            'CLASS_NAME_PLURAL' => $pluralName,
            'CLASS_NAME_PLURAL_TABLEIZED' => $pluralNameTableized,
            'CLASS_NAME_PLURAL_CAMEL' => $camelPluralName,
            'CLASS_NAME_CAMEL' => $camelName,
        ];

        // Controller
        $filePath = base_path('app\\Http\\Controllers\\Admin') .'\\' .$upperCaseNamePlural . 'Controller.php';
        $this->makeDirectory(dirname($filePath));
        $stubPath = __DIR__ . '/crudStubs/Controller.stub';

        $this->createStub($stubPath, $variables, $filePath);

        // Model
        $filePath = base_path('app\\Models') .'\\' .$upperCaseName . '.php';
        $this->makeDirectory(dirname($filePath));
        $stubPath = __DIR__ . '/crudStubs/Model.stub';

        $this->createStub($stubPath, $variables, $filePath);


        // Store Request
        $filePath = base_path('app\\Http\\Requests') .'\\Store' .$upperCaseName . 'Request.php';
        $this->makeDirectory(dirname($filePath));

        $stubPath = __DIR__ . '/crudStubs/StoreRequest.stub';

        $this->createStub($stubPath, $variables, $filePath);

        // Update Request
        $filePath = base_path('app\\Http\\Requests') .'\\Update' .$upperCaseName . 'Request.php';
        $this->makeDirectory(dirname($filePath));

        $stubPath = __DIR__ . '/crudStubs/UpdateRequest.stub';

        $this->createStub($stubPath, $variables, $filePath);

        // Mass Destroy Request
        $filePath = base_path('app\\Http\\Requests') .'\\MassDestroy' .$upperCaseName . 'Request.php';
        $this->makeDirectory(dirname($filePath));

        $stubPath = __DIR__ . '/crudStubs/MassDestroyRequest.stub';

        $this->createStub($stubPath, $variables, $filePath);


        // Migration
        $filePath = base_path('database\\migrations') .'\\' . Carbon::now()->format('Y_m_d_hms') . '_create_' . $pluralNameTableized . '_table.php';
        $this->makeDirectory(dirname($filePath));

        $stubPath = __DIR__ . '/crudStubs/migration.stub';

        $this->createStub($stubPath, $variables, $filePath);

        // Seeder
        $filePath = base_path('database\\seeders') .'\\' . $upperCaseNamePlural . 'TableSeeder.php';
        $this->makeDirectory(dirname($filePath));

        $stubPath = __DIR__ . '/crudStubs/seeder.stub';

        $this->createStub($stubPath, $variables, $filePath);

        // Create Vue Component
        $filePath = base_path('resources\\js\\Pages') .'\\' . $upperCaseNamePlural . '.vue';
        $this->makeDirectory(dirname($filePath));

        $stubPath = __DIR__ . '/crudStubs/vueComponent.stub';

        $this->createStub($stubPath, $variables, $filePath);

        // Append to routes (web.php)
        $filePath = base_path('routes') .'\\web.php';
        $search = "    Route::get('/', 'HomeController@index')
        ->name('home');";
        $insert = "\n    // {$upperCaseNamePlural}\n    Route::delete('$pluralNameTableized/destroy', '{$upperCaseNamePlural}Controller@massDestroy')->name('$pluralNameTableized.massDestroy');
    Route::apiResource('$pluralNameTableized', '{$upperCaseNamePlural}Controller');";

        $replace = $search. "\n". $insert;

        $this->files->put($filePath, str_replace($search, $replace, file_get_contents($filePath)));
        $this->info("Appended to : {$filePath}");

        // Append to AppLayout
        $filePath = base_path('resources\\js\\Layouts') .'\\AppLayout.vue';
        $search = "{ name: 'Sākums', routeName: 'home', icon: HomeIcon},";
        $insert = "    {name: '{$upperCaseNamePlural}', routeName: '{$pluralNameTableized}.index', icon: CollectionIcon, can: ['{$tableizedName}_read']},";

        $replace = $search. "\n". $insert;

        $this->files->put($filePath, str_replace($search, $replace, file_get_contents($filePath)));
        $this->info("Appended to : {$filePath}");

        // Append Seeder DatabaseSeeder.php
        $filePath = base_path('database\\seeders') .'\\DatabaseSeeder.php';
        $search = "RoleUserTableSeeder::class,";
        $insert = "\n            {$upperCaseNamePlural}TableSeeder::class,";

        $replace = $search. "\n". $insert;

        $this->files->put($filePath, str_replace($search, $replace, file_get_contents($filePath)));
        $this->info("Appended to : {$filePath}");

        // Append to PermissionsSeeder
        $filePath = base_path('database\\seeders') .'\\PermissionsTableSeeder.php';
        $search = "// autogenerated here";
        $insert = "            [
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

        $replace = $search. "\n". $insert;

        $this->files->put($filePath, str_replace($search, $replace, file_get_contents($filePath)));
        $this->info("Appended to : {$filePath}");

        // finished
        $this->info('');
        $this->info('Command completed.');
    }

    public function createStub($stubPath, $variables, $filePath)
    {
        $contents = $this->getStubContents($stubPath, $variables);

        if (!$this->files->exists($filePath)) {
            $this->files->put($filePath, $contents);
            $this->info("Created : {$filePath}");
        } else {
            $this->info("Not created : {$filePath} already exists");
        }
    }

    /**
     * Replace the stub variables(key) with the desire value
     *
     * @param $stub
     * @param array $stubVariables
     * @return bool|mixed|string
     */
    public function getStubContents($stub , $stubVariables = [])
    {
        $contents = file_get_contents($stub);

        foreach ($stubVariables as $search => $replace)
        {
            $contents = str_replace('$'.$search.'$' , $replace, $contents);
        }

        return $contents;
    }

    /**
     * Build the directory for the class if necessary.
     *
     * @param  string  $path
     * @return string
     */
    protected function makeDirectory($path)
    {
        if (! $this->files->isDirectory($path)) {
            $this->files->makeDirectory($path, 0755, true, true);
        }

        return $path;
    }

}
