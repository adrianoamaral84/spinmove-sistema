<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebhookController;

Route::post('/webhook/whatsapp', [WebhookController::class, 'receber']);