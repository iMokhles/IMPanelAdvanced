<?php

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

// Backup package
Route::get('backup', 'BackupController@index');
Route::put('backup/create', 'BackupController@create');
Route::get('backup/download/{file_name?}', 'BackupController@download');
Route::delete('backup/delete/{file_name?}', 'BackupController@delete')->where('file_name', '(.*)');

// LogManager Package
Route::get('log', 'LogController@index');
Route::get('log/preview/{file_name}', 'LogController@preview');
Route::get('log/download/{file_name}', 'LogController@download');
Route::delete('log/delete/{file_name}', 'LogController@delete');

// MenuCRUD
CRUD::resource('menu-item', 'MenuItemCrudController');

// Settings
CRUD::resource('setting', 'SettingCrudController');

// Pages
CRUD::resource('page', 'PageCrudController');
