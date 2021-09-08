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
    $urls = DB::table('urls')
        ->selectRaw('urls.*, max(url_checks.id) as last_url_check_id')
        ->leftJoin('url_checks', 'urls.id', '=', 'url_checks.url_id')
        ->groupBy(['urls.id', 'urls.name'])
        ->get();
    $urls = $urls->map(function ($url) {
        if (empty($url->last_url_check_id)) {
            $url->checked_at = '';
            $url->status_code = '';
        } else {
            $url_check = DB::table('url_checks')
                ->find($url->last_url_check_id);
            $url->checked_at = $url_check->created_at;
            $url->status_code = $url_check->status_code;
        }
        return $url;
    });
    return view('urls.index', compact('urls'));
})->name('urls.index');

Route::get('/urls/{id}', function ($id) {
    $url = DB::table('urls')
        ->find($id);
    $url_checks = DB::table('url_checks')
        ->where('url_id', '=', $id)
        ->get();
    return view('urls.show', compact('url', 'url_checks'));
})->name('urls.show');

Route::post('/urls', function (Request $request) {
    $data = $request->all();
    $url = $data['url'];
    if ($url['name'] === null
        || filter_var($url['name'], FILTER_VALIDATE_URL) === false
        || strlen($url['name']) > 255
    ) {
        flash('Input valid url')->error();
        return view('urls.create', compact('url'));
    }
    $name = $url['name'];
    $url = DB::table('urls')->where('name', '=', $name)->first();
    if ($url === null) {
        DB::table('urls')->insert([
            'name' => $name,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }

    flash('Url was created')->success();
    return redirect()
        ->route('urls.index');
})->name('urls.store');

Route::post('/urls/{id}/checks', function ($id) {
    DB::table('url_checks')->insert([
        'url_id' => $id,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
    ]);
    return redirect()
        ->route('urls.show', ['id' => $id]);
})->name('urls.check');
