<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DeveloperController extends Controller
{
    public function getSupplierName(Request $request):string
    {
        $name = $request->input('name');
        return $name;
    }
}
