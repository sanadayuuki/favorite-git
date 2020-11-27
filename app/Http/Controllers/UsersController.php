<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index(){
        
        //ユーザーIDを逆順で取得
        $users = User::orderBy('id','desc')->paginate(1);
        
        //ユーザー一覧ビューでそれを表示
        
        return view('users.index',[
            'users => $users',
        ]);
    }
    
    public function show($id)
    {
        // idの値でユーザを検索して取得
        $user = User::findOrFail($id);

        // ユーザ詳細ビューでそれを表示
        return view('users.show', [
            'user' => $user,
        ]);
    }
}
