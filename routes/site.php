<?php

Route::namespace('Site')
    ->group(function() {

    Route::get('/', 'HomeController@index')->name('site.home');
});
