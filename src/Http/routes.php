<?php

Route::group([
    'namespace'  => 'Adoreparler\Seat\Charinfo\Http\Controllers',
    'middleware' => ['web', 'auth', 'can:charinfo.view'],
    'prefix'     => 'charinfo'
], function () {

    Route::get('/', [
        'as'   => 'charinfo::list',
        'uses' => 'CharinfoController@list'
    ]);

    // Handle trailing slash explicitly
    Route::get('/{any}', function () {
        return redirect()->route('charinfo::list');
    })->where('any', '.*');

});
