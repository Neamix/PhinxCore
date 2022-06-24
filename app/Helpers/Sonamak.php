<?php 

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Admin\PostController;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Schema;

class Sonamak {

    static function routes()
    {
        $route_table_exist = Schema::hasTable('routes');

        if ( $route_table_exist ) {
            $routes = DB::table('routes')->get();

            foreach( $routes as $route ) {
    
                $name  = $route->name;
                $lowername = strtolower($name);
                $type = $route->type;
    
                Route::group(['prefix' => $lowername], function() use ($name,$type,$lowername) {
    
                    $uppername = ucwords($name);
                    $controller = "Admin\\".$uppername."Controller";
                    Route::get("/","$controller@index")->name("$lowername");
                    Route::post("/store","$controller@store")->name("$lowername.store");
                    Route::post("/more","$controller@more")->name("$lowername.more");
                    Route::post('/delete/'.'{'.$lowername.'}',"$controller@delete")->name("$lowername.delete");
    
    
                    if ( $type == 'multi' ) {
                        Route::get('/upsert/'.'{'.$lowername.'?}',"$controller@upsert")->name("$lowername.upsert");
                    }
    
                    
                });
    
            }   
        }
    }
}