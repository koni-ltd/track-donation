<?php

namespace App\Http\Controllers;

use App\Models\User;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // User モデルを使って全ユーザーのデータを取得
        $users = User::all();

        // 取得したデータをビューに渡す
        return view('home', compact('users'));
    }
}
