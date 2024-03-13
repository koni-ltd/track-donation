<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class MyPageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    // マイページ
    public function myPage()
    {
        // ログイン中のユーザーを取得
        $user = Auth::user();

        // ビューを表示
        return view('myPage', compact('user'));
    }
}
