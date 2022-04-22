<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Pluralizer;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class SonamakCrud extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sonamak:crud {name} {--type=multi}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Crud Process';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function getCapitalizedName()
    {
       return $this->argument('name');
    }

    public function getCrudsArray()
    {
        $name =  $this->getCapitalizedName();

        $capitalized_name = ucwords($name);

        $controller_name  = $name.'Controller';

        $request_name = $name.'Request';

        $plural = Pluralizer::plural($name, 2);

        return [
            'controller' =>  $controller_name,
            'model' => $capitalized_name,
            'request' => $request_name,
            'migration' => "create_".$plural."_table"
        ];
    }


    public function getContent($value)
    {

        $main_directory = base_path() .'/stubs/';

        if ( $value == 'controller' ) {

            $file_content = file_get_contents($main_directory.'SonamakController.stub');

        } else {

            $file_content = file_get_contents($main_directory.'SonamakModel.stub');

        }

        return $file_content;
    }

    public function insertValues($value) {

        $get_content = $this->getContent($value);

        $get_crud_array = $this->getCrudsArray();

        if ( $value == 'controller' ) {

            $pluralName  = strtolower(strtolower($get_crud_array['model'])).'s';
            $get_content = str_replace('$model',$get_crud_array['model'],$get_content);
            $get_content = str_replace('$modlower',strtolower($get_crud_array['model']),$get_content);
            $get_content = str_replace('$plural',$pluralName,$get_content);
            $get_content = str_replace('$controllername',$get_crud_array['controller'],$get_content);

            $path = app_path().'/Http/Controllers/Admin/';

            $file = fopen($path.$get_crud_array['controller'].'.php','w');

            fwrite($file,$get_content);

            $this->info("Controller Created Successfully");

        }

        if ( $value == 'model' ) {

            $pluralName  = strtolower(strtolower($get_crud_array['model'])).'s';
            $get_content = str_replace('$model',$get_crud_array['model'],$get_content);
            $get_content = str_replace('$modlower',strtolower($get_crud_array['model']),$get_content);
            $get_content = str_replace('$plural',$pluralName,$get_content);

            $path = app_path().'/Models/';

            $file = fopen($path.$get_crud_array['model'].'.php','w');

            fwrite($file,$get_content);

            $this->info("Model Created Successfully");

        }
        


        return $get_content;

    } 

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // $this->choice('WhaT is the kind of view that you need',[
        //     'Single Panal',
        //     'Multiple Panal'
        // ],'Single Panal');

        foreach($this->getCrudsArray() as $key => $crud)
        {
            $this->insertValues($key);
        }

        $get_crud_array = $this->getCrudsArray();

        $migration_name = $get_crud_array['migration'];
        $request_name   = $get_crud_array['request'];

        Artisan::call("make:migration $migration_name");
        $this->info("Migration Created Successfully");
        Artisan::call("make:request $request_name");
        $this->info("Request Created Successfully");

        $group = $this->ask('What group you want?');

        DB::table('routes')->insert([
            'name' => $this->argument('name'),
            'group' => $group,
            'type'  => $this->option('type') 
        ]);
    }
}
