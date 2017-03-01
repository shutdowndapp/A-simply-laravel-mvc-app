<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Auth;

use App\Author;

class AdminController extends Controller
{
    public function getLogin(Request $request)
    {
        return view('admin.login');
    }

    public function getLogout()
    {
        Auth::logout();
        return redirect()->route('index');
    }

    public function getDashBoard()
    {
        // if (!Auth::check()) {
        //     return redirect()->back();
        // }
        $authors = Author::all();
        return view('admin.dashboard',['authors' => $authors]);
    }

    public function postLogin(Request $request)
    {
        $this->validate($request,[
            'name' => 'required',
            'password' => 'required'
        ]);

        if( !Auth::attempt(['name' => $request->name, 'password' => $request->password]) ) {
            return redirect()->back()->with(['fail' => 'could not login']);
        }
        return redirect()->route('admin.dashboard');
    }

}
