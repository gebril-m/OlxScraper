<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('tabs/{id}/get_number_of_pagination','ScrapController@get_number_of_pagination');
Route::get('tabs/{id}/get_number_of_ads','ScrapController@get_number_of_ads');
Route::get('tabs/{id}/store_ads','ScrapController@store_ads');
Route::get('tabs/{tab_id}/change_following/{id}/{value}','ScrapController@change_following');

// Login 
Route::group(['middleware' => 'guest' ], function () {

	Route::get('login','AuthController@login_page')->name('login_page');
	Route::post('login','AuthController@login')->name('login');

});

Route::get('create-tab',function(){
	$advertisings=\App\Models\Advertising::all();
	return view('admin.createTab',compact('advertisings'));
});

// Dashboard
Route::group(['middleware' => 'auth:web' ], function () {

	Route::get('logout','AuthController@logout')->name('logout');

	//Only For Super Admin
	Route::group(['middleware' => ['role:super-admin']], function () {
	    Route::get('/', function () {
		    return view('admin.index');
		});
		Route::resource('/projects', 'ProjectController');
	});

	//Only For User
	Route::group(['middleware' => ['role:user']], function () {
	    Route::get('/user-projects', 'ProjectController@index');
	});

	//Permissions & Roles
	
		Route::resource('permissions','PermissionController');
		Route::resource('roles','RoleController');
	

	Route::resource('users','UserController');
	Route::get('edit-profile','UserController@edit_profile')->name('edit-profile');

	//SCRAPING
	Route::get('olx-scraping','ScrapController@get_data_olx');
	Route::get('olx-one-scraping','ScrapController@get_data_olx_one');
	Route::get('get-url-pages-number','ScrapController@get_url_pages_number');
	
	
	
	Route::get('tabs/save_data_for_one_link','ScrapController@save_data_for_one_link');
	Route::get('tabs/toggole_check_if_exist_in_contact_base','ScrapController@toggole_check_if_exist_in_contact_base');


	Route::get('scraping/index','ScrapController@index');
	Route::get('scraping/page-of-scraping','ScrapController@olx_scraping_page');
	Route::get('scraping/show/{id}','ScrapController@show');

		//Tabs
		Route::resource('tabs','TabController');

		//Links
		Route::resource('pagelinks','PagelinkController');
		Route::get('pagelinks/{id}/scraping-page','PagelinkController@scraping_page');


});