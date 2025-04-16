<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;

class BaseController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    protected function successResponse($route, $message, $params = [])
    {
        return redirect()
            ->route($route, $params)
            ->with('success', $message);
    }

    protected function errorResponse($route, $message, $params = [])
    {
        return redirect()
            ->route($route, $params)
            ->with('error', $message);
    }
}
