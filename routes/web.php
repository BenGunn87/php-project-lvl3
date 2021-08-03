<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    $url = [];
    return view('urls.create', compact('url'));
})->name('urls.create');

Route::get('/urls', function () {
    $urls = DB::table('urls')->get();
    return view('urls.index', compact('urls'));
})->name('urls.index');

Route::post('/urls', function (Request $request) {
    $data = $request->all();
    $url = $data['url'];
    if ($url['name'] === null || filter_var($url['name'], FILTER_VALIDATE_URL) === false) {
        flash('Input valid url')->error();
        return view('urls.create', compact('url'));
    }

    DB::table('urls')->insert([
        'name' => $data['url']['name'],
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
    ]);

    flash('Url was created')->success();
    return redirect()
        ->route('urls.index');
})->name('urls.store');
