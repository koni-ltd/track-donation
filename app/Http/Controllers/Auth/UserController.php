<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return view('auth/account', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'address' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // 以前の画像を削除
            if ($user->image) {
                $oldImagePath = str_replace('/storage', '', $user->image);
                Storage::delete('/public' . $oldImagePath);
            }

            // 新しい画像を保存
            $imagePath = $request->file('image')->store('public/users');
            $user->image = Storage::url($imagePath);
        }

        $user->name = $request->name;
        $user->email = $request->email;
        if (!empty($request->password)) {
            $user->password = Hash::make($request->password);
        }
        $user->address = $request->address;
        $user->description = $request->description;

        $user->save();

        return redirect()->route('home')->with('success', 'Profile updated successfully.');
    }

    public function destroy()
    {
        $user = Auth::user();

        // ユーザーの画像がある場合は削除
        if ($user->image) {
            $imagePath = str_replace('/storage', '', $user->image);
            Storage::delete('/public' . $imagePath);
        }

        // ユーザーの論理削除
        $user->delete();

        return redirect()->route('home')->with('success', 'Account deleted successfully.');
    }
}
