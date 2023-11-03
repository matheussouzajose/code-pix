<?php

use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::group([], base_path('src/Ui/Api/Routing/pix-keys.php'));
});
