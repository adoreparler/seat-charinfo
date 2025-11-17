<?php

// SeAT plugin routes - wrapped in group for namespace/prefix/middleware
Route::group([
    'namespace'  => 'Adoreparler\Seat\Charinfo\Http\Controllers',
    'middleware' => ['web', 'auth', 'can:charinfo.view'],
    'prefix'     => 'charinfo'
], function () {

    Route::get('/', [
        'as'   => 'charinfo::list',
        'uses' => 'CharinfoController@list'
    ]);

});
