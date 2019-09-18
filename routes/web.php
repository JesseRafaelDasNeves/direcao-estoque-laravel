<?php

Route::get('/'    , 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');
Auth::routes();

Route::resource('/pessoas'     , 'PessoaController');
Route::resource('/fornecedores', 'FornecedorController');
Route::resource('/produtos'    , 'ProdutoController');
Route::resource('/entradas'    , 'EntradaController');

Route::resource('/entradas/{identrada}/itemEntrada', 'ItemEntradaController');

