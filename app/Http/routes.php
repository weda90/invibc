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

Route::get('/', function () {
    return view('welcome');
});

Route::auth();

Route::group(['middleware' => ['auth']], function() {

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
	
	Route::group(['prefix'=>'api/v1'], function()
	{
		// Route::resource('material','ApiMasterController@material');
		// Route::get('material',['as'=>'api.master.material.index ','uses'=>'ApiMasterController@material_index']);
		// 
		Route::get('material',['as'=>'api.master.material.index ','uses'=>'Api\MasterController@material_index']);
		Route::post('material',['as'=>'api.master.material.store ','uses'=>'Api\MasterController@material_store']);
		Route::put('material/{id}',['as'=>'api.master.material.update ','uses'=>'Api\MasterController@material_update']);
		Route::get('material/{id}',['as'=>'api.master.material.show ','uses'=>'Api\MasterController@material_show']);
		Route::delete('material/{id}',['as'=>'api.master.material.destroy ','uses'=>'Api\MasterController@material_destroy']);
		// Route::post('material',['as'=>'api.master.material.store ','uses'=>'ApiMasterController@material_store']);


		Route::resource('company','ApiMasterController@company');
	});


});
