<?php

Route::get('/', [
    'as' => 'charinfo.list',
    'uses' => 'Adoreparler\Seat\Charinfo\Http\Controllers\CharinfoController@list',
    'middleware' => ['web', 'auth', 'can:charinfo.view'],
]);
