<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SharedMethodsController extends Controller
{
    public static function languagesAvailable()
    {
        return ['en', 'pt'];
    }
}
