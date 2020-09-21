<?php
use think\facade\Route;
Route::group('', function () {
    Route::rule('/news/index', '\mpayment\controller\Payment@index' );
    Route::rule('/news/show', '\mpayment\controller\Payment@show');
    Route::rule('/news/save', '\mpayment\controller\Payment@save' );

});
//
//Route::group('', function () {
//    Route::rule('/news/save', '\mpayment\controller\Payment@save' );
//
//})->middleware('auth','u');