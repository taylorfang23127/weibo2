<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
class StaticPagesController extends Controller
{
    public function home()
    {
        // return '主页';
        $feed_items = [];
        if (Auth::check()) {
            # code...
            $feed_items = Auth::user()->feed()->paginate(30);
        }
        return view('static_pages/home',compact('feed_items'));
    }

     public function help()
    {
        // return '帮助页面';
        return view('static_pages/help');

    }

     public function about()
    {
        // return '关于页面';
        return view('static_pages/about');

    }
}
