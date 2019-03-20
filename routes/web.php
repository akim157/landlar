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

//...
Route::group(['middleware' => 'web'], function()
{
    //
    Route::match(['get', 'post'],'/', 'IndexController@execute')->name('home');
    //page/{alias}
    Route::get('/page/{alias}', 'PageController@execute')->name('page');

    Auth::routes();
});

//admin/...
Route::group(['prefix' => 'admin', 'middleware' => ['web', 'auth']], function()
{
    //admin/
    Route::get('/', function(){
        if(view()->exists('admin.index'))
        {
            $data = ['title' => 'Панель администратора'];
            return view('admin.index', $data);
        }
    })->name('admin');
    //admin/pages
    Route::group(['prefix' => 'pages'], function(){
        //admin/pages
        Route::get('/', 'PagesController@execute')->name('pages');
        //admin/pages/add
        Route::match(['get', 'post'], '/add', 'PagesAddController@execute')->name('pages_add');
        //admin/pages/edit/{page}
        Route::match(['get', 'post', 'delete'], '/edit/{page}', 'PagesEditController@execute')->name('pages_edit');
    });

    //admin/portfolios
    Route::group(['prefix' => 'portfolios'], function(){
        //admin/portfolios
        Route::get('/', 'PortfolioController@execute')->name('portfolio');
        //admin/portfolios/add
        Route::match(['get', 'post'], '/add', 'PortfolioAddController@execute')->name('portfolio_add');
        //admin/portfolios/edit/{portfolio}
        Route::match(['get', 'post', 'delete'], '/edit/{portfolio}', 'PortfolioEditController@execute')->name('portfolio_edit');
    });

    //admin/services
    Route::group(['prefix' => 'services'], function(){
        //admin/services
        Route::get('/', 'ServiceController@execute')->name('services');
        //admin/services/add
        Route::match(['get', 'post'], '/add', 'ServiceAddController@execute')->name('service_add');
        //admin/services/edit/{service}
        Route::match(['get', 'post', 'delete'], '/edit/{service}', 'ServiceEditController@execute')->name('service_edit');
    });
});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
