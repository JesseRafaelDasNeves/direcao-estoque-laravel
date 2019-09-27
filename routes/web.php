<?php

Route::get('/'    , 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::resource('/pessoas'     , 'PessoaController');
Route::resource('/fornecedores', 'FornecedorController');
Route::resource('/produtos'    , 'ProdutoController');
Route::resource('/entradas'    , 'EntradaController');
Route::resource('/saidas'      , 'SaidaController');

Route::resource('/entradas/{identrada}/itemEntrada', 'ItemEntradaController');
Route::resource('/saidas/{idsaida}/itemSaida'      , 'ItemSaidaController');

Route::get('/entradas/{id}/conclui', 'EntradaController@conclui')->name('entradas.conclui');
Route::get('/saidas/{id}/conclui'  , 'SaidaController@conclui')->name('saidas.conclui');
Route::get('/saidas/{idsaida}/itemSaida/qtdeEstoqueProduto/{id}/', 'ItemSaidaController@getQtdeEstoqueProduto');