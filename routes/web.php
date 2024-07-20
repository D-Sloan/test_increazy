<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CepSearch;

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


Route::get('search/local/{ceps}', [CepSearch::class, 'searchCEP']);

Route::get('/', function () {
    return view('welcome');
});
