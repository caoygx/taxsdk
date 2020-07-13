<?php
use think\facade\Route;
Route::group('', function () {
    Route::rule('/news/index', '\mnews\controller\News@index' );
    Route::rule('/news/show', '\mnews\controller\News@show');
    Route::rule('/news/save', '\mnews\controller\News@save' );

});
//
//Route::group('', function () {
//    Route::rule('/news/save', '\mnews\controller\News@save' );
//
//})->middleware('auth','u');