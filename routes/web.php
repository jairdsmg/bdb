<?php

use Illuminate\Support\Facades\Route;
use App\Mail\MensagemTesteMail;

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
    return view('welcome');
});

Auth::routes(['verify' => true]);

Route::get('/preco/exportacao', 'App\Http\Controllers\PrecoController@exportacao')->name('preco.exportacao')->middleware('auth')->prefix('v1');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware(['auth', 'verified']);
Route::get('/produtos',  function(){
    return view('app.produtos');
})->name('produtos')->middleware(['auth', 'verified']);
Route::get('/precos',  function(){
    return view('app.precos');
})->name('precos')->middleware('auth');

Route::get('/mensagem-teste', function(){
    return new MensagemTesteMail();
  // Mail::to('jairdsmg@gmail.com')->send(new MensagemTesteMail());
   return 'Email enviado com sucesso!';

});
