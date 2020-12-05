<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FavoritesController extends Controller
{
    /**
     * ツイートをお気に入りに追加するアクション。
     *
     * @param  $id  ツイートのid
     * @return \Illuminate\Http\Response
     */
     public function store($id){
         
         \Auth::user()->favorite($id);
         //前のURLへリダイレクトさせる
         return back();
     }
     
    /**
     * ツイートをお気に入りから削除するアクション
     *
     * @param  $id  ツイートのid
     * @return \Illuminate\Http\Response
     */
     public function destroy($id){
         //認証済みユーザー（閲覧者）が、idのツイートをお気に入りから削除する
         \Auth::user()->unfavorite($id);
         //前のURLにリダイレクトさせる
         return back();
     }
}
