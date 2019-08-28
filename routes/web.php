<?php

Route::get('/'    , 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');
Auth::routes();

Route::resource('/pessoas', 'PessoaController');

