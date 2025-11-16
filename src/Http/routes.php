<?php

Route::get('/', [
    'as' => 'charinfo.list',
    'uses' => 'Seat\Charinfo\Http\Controllers\CharinfoController@list',
    'middleware' => ['web', 'auth', 'can:charinfo.view'],
]);
