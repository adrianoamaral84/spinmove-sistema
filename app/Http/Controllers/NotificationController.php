<?php

namespace App\Http\Controllers;

use App\Models\Notification;

class NotificationController extends Controller
{

    public function marcar($id)
{

    \App\Models\Notification
    ::where(
        'id',
        $id
    )

    ->update([

        'lida'=>1

    ]);

    return response()
    ->json([
        'ok'=>true
    ]);

}

}