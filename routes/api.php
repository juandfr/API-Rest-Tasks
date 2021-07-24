<?php

Route::namespace('Api')
    ->middleware('auth')
    ->group(function() {

    Route::apiResource('tasks', 'TasksController');
});
