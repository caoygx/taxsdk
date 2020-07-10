<?php
use think\facade\Route;
Route::group('', function () {

    Route::rule('/news/index', '\mnews\controller\News@index' );
    Route::rule('/news/show', '\mnews\controller\News@show');

});
    //->middleware([\app\middleware\Auth::class],'home');