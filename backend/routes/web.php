<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LinkController;


Route::get('/{valor}',[LinkController::class, 'redirectLink']);
