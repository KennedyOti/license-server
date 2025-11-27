<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;

class ApiDocsController extends Controller
{
    public function index()
    {
        return view('portal.api-docs.index');
    }
}