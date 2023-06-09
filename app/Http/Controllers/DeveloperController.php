<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exceptions\CustomException;

class DeveloperController extends Controller
{
    public function getSupplierName(Request $request):string
    {
        $name = $request->input('name');
        //总感觉这种用法是不对的，但是有说不出原因
        try {
            // some code that may throw CustomException
        } catch (CustomException $e) {
            //
        }
        return $name;
    }
}
