<?php
namespace library\libs;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
class AppRoute extends  Route {
    public static function apiResource( string $name, string $controller, array $options = [] ) {
        //$single = Str::singular( $name );
        parent::match( ['get','post'],$name . "/list", [ $controller, "index" ] );
        //parent:://( $name . "/list", [ $controller, "index" ] );
        parent::apiResource( $name, $controller, ['except'=>['index']] );
        /* Route::get($name."/{{$single}}",[$controller,"show"]);
         Route::post($name."/add",[$controller,"store"]);
         Route::patch($name."/update/{{$single}}",[$controller,"update"]);
         Route::delete($name."/{{$single}}",[$controller,"destroy"]);*/
    }
}
