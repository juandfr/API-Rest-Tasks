<?php

Auth::routes();


Route::namespace('Admin')
    ->prefix('admin')
    ->group(function() {

    Route::get('/tasks/index', 'TasksController@index')->name('admin.tasks.index');
});
