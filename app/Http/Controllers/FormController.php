<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FormController extends Controller
{
    public static function processForm(Request $request)
    {
        //$slovakValue = $request->input('slovak');
        //$allData = $request->all();
        //dd($slovakValue, $allData);
        //dd($slovakValue);
        if ($request->input('slovak')==="true") {
            $request->session()->put('language', 'slovak');

        }
        //if ($request->isMethod('post') && $request->has('english')) {
        if ($request->input('english')=="true") {
            $request->session()->put('language', 'english');
        }
        return redirect()->back();
    }
}
