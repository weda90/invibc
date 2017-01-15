<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*Route::get('/', function () {
    return view('welcome');
});*/


Route::auth();

Route::group(['middleware' => ['auth']], function() {

	Route::get('/', 'HomeController@index');
	Route::get('/home', 'HomeController@index');

	Route::resource('users','UserController');

	Route::get('roles',['as'=>'roles.index','uses'=>'RoleController@index','middleware' => ['permission:role-list|role-create|role-edit|role-delete']]);
	Route::get('roles/create',['as'=>'roles.create','uses'=>'RoleController@create','middleware' => ['permission:role-create']]);
	Route::post('roles/create',['as'=>'roles.store','uses'=>'RoleController@store','middleware' => ['permission:role-create']]);
	Route::get('roles/{id}',['as'=>'roles.show','uses'=>'RoleController@show']);
	Route::get('roles/{id}/edit',['as'=>'roles.edit','uses'=>'RoleController@edit','middleware' => ['permission:role-edit']]);
	Route::patch('roles/{id}',['as'=>'roles.update','uses'=>'RoleController@update','middleware' => ['permission:role-edit']]);
	Route::delete('roles/{id}',['as'=>'roles.destroy','uses'=>'RoleController@destroy','middleware' => ['permission:role-delete']]);

	// Route::get('master/material','MasterController');
	Route::get('master/material',['as'=>'master.material','uses'=>'MasterController@material']);
	Route::get('master/company',['as'=>'master.company','uses'=>'MasterController@company']);
	Route::get('stock/receiving',['as'=>'stock.receiving','uses'=>'StockController@receiving']);
	Route::get('stock/outgoing',['as'=>'stock.outgoing','uses'=>'StockController@outgoing']);
	Route::get('report/{id}',['as'=>'report.outgoing','uses'=>'ReportController@index']);
	
	Route::group(['prefix'=>'api/v1'], function()
	{
		// Route::resource('material','ApiMasterController@material');
		// Route::get('material',['as'=>'api.master.material.index ','uses'=>'ApiMasterController@material_index']);
		// 
		Route::get('master/material',['as'=>'api.master.material.index ','uses'=>'Api\MasterController@material_index']);
		Route::post('master/material',['as'=>'api.master.material.store ','uses'=>'Api\MasterController@material_store']);
		Route::put('master/material/{id}',['as'=>'api.master.material.update ','uses'=>'Api\MasterController@material_update']);
		Route::get('master/material/{id}',['as'=>'api.master.material.show ','uses'=>'Api\MasterController@material_show']);
		Route::delete('master/material/{id}',['as'=>'api.master.material.destroy ','uses'=>'Api\MasterController@material_destroy']);
		// Route::post('material',['as'=>'api.master.material.store ','uses'=>'ApiMasterController@material_store']);

		Route::get('master/company',['as'=>'api.master.company.index ','uses'=>'Api\MasterController@company_index']);
		Route::post('master/company',['as'=>'api.master.company.store ','uses'=>'Api\MasterController@company_store']);
		Route::put('master/company/{id}',['as'=>'api.master.company.update ','uses'=>'Api\MasterController@company_update']);
		Route::get('master/company/{id}',['as'=>'api.master.company.show ','uses'=>'Api\MasterController@company_show']);
		Route::delete('master/company/{id}',['as'=>'api.master.company.destroy ','uses'=>'Api\MasterController@company_destroy']);

		// Route::get('stock/receiving',['as'=>'api.stock.receiving.index ','uses'=>'Api\StockController@receiving_index']);
		// Route::post('stock/receiving',['as'=>'api.stock.receiving.store ','uses'=>'Api\StockController@receiving_store']);
		// Route::put('stock/receiving/{id}',['as'=>'api.stock.receiving.update ','uses'=>'Api\StockController@receiving_update']);
		// Route::get('stock/receiving/{id}',['as'=>'api.stock.receiving.show ','uses'=>'Api\StockController@receiving_show']);
		// Route::delete('stock/receiving/{id}',['as'=>'api.stock.receiving.destroy ','uses'=>'Api\StockController@receiving_destroy']);
		
		Route::get('stock/{type}/{id}',array('as' => 'api.v1.stock.{type}.show', 'uses' => 'Api\StockController@show'));
		Route::put('stock/{type}/{id}',array('as' => 'api.v1.stock.{type}.update', 'uses' => 'Api\StockController@update'));
		Route::delete('stock/{type}/{id}',array('as' => 'api.v1.stock.{type}.destroy', 'uses' => 'Api\StockController@destroy'));
		Route::resource('stock/{type}','Api\StockController', array('only' => array('index', 'store')));

		Route::get('report/{id}',array('as' => 'api.v1.report.index', 'uses' => 'Api\ReportController@index'));



	});


});
