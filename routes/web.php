<?php

Route::get('/'    , 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::resource('/pessoas'     , 'PessoaController')    ->parameters(['pessoas'      => 'id']);
Route::resource('/fornecedores', 'FornecedorController')->parameters(['fornecedores' => 'id']);
Route::resource('/produtos'    , 'ProdutoController')   ->parameters(['produtos'     => 'id']);
Route::resource('/entradas'    , 'EntradaController')   ->parameters(['entradas'     => 'id']);
Route::resource('/saidas'      , 'SaidaController')     ->parameters(['saidas'       => 'id']);

Route::resource('/entradas/{identrada}/itemEntrada', 'ItemEntradaController')->parameters([
    'entradas'    => 'identrada',
    'itemEntrada' => 'id',
]);
Route::resource('/saidas/{idsaida}/itemSaida', 'ItemSaidaController')->parameters([
    'saidas'    => 'idsaida',
    'itemSaida' => 'id',
]);

Route::get('/entradas/{id}/conclui', 'EntradaController@conclui')->name('entradas.conclui');
Route::get('/saidas/{id}/conclui'  , 'SaidaController@conclui')->name('saidas.conclui');
Route::get('/saidas/{idsaida}/itemSaida/qtdeEstoqueProduto/{id}/', 'ItemSaidaController@getQtdeEstoqueProduto');

Route::get('/estoque/movimentacoes', 'EstoqueController@movimentacoes')->name('movimentacoes-estoque');