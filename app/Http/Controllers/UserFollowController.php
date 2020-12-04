<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserFollowController extends Controller
{
    /**
     * ユーザをフォローするアクション。
     *
     * @param  $id  相手ユーザのid
     * @return \Illuminate\Http\Response
     */
     public function store($id){
         //認証済みユーザー（閲覧者）が、idのユーザーをフォローする
         
         \Auth::user()->follow($id);
         //前のURLへリダイレクトさせる
         return back();
     }
     
    /**
     * ユーザをアンフォローするアクション。
     *
     * @param  $id  相手ユーザのid
     * @return \Illuminate\Http\Response
     */
     public function destory($id){
         //認証済みユーザー（閲覧者）が、idのユーザーをアンフォローする
         \Auth::user()->unfollow($id);
         //前のURLにリダイレクトさせる
         return back();
     }
}
