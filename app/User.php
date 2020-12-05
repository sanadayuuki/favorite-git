<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    /**
     * このユーザが所有する投稿。（ Micropostモデルとの関係を定義）
     */
    public function microposts()
    {
        return $this->hasMany(Micropost::class);
    }
      /**
     * このユーザが所有する投稿。（ Micropostモデルとの関係を定義）
     */
    public function followings(){
        return $this->belongsToMany(User::class,'user_follow','user_id','follow_id')->withTimestamps();
    }
    
    /**
     * このユーザがフォロー中のユーザ。（ Userモデルとの関係を定義）
     */
    public function followers(){
        return $this->belongsToMany(User::class,'user_follow','follow_id','user_id')->withTimestamps();
    }
    /**
     * このユーザがお気に入り登録中のツイート。（ Userモデルとの関係を定義）
     */
    public function favorites(){
        return $this->belongsToMany(Micropost::class,'favorites','user_id','micropost_id')->withTimestamps();
    }
    
     public function loadRelationshipCounts(){
         $this->loadCount(['microposts', 'followings', 'followers','favorites']);
     }
    
    public function follow($userId){
        
        // すでにフォローしているかの確認
        $exist = $this->is_following($userId);
        // 相手が自分自身かどうかの確認
        $its_me = $this->id==$userId;
        
        if($exist || $its_me){
            // すでにフォローしていれば何もしない
            return false;
        }else{
            //未フォローであればフォローする
            $this->followings()->attach($userId);
            return true;
        }
    }
    
   /**
     * $userIdで指定されたユーザをアンフォローする。
     *
     * @param  int  $userId
     * @return bool
     */
     
     public function unfollow($userId){
         
        // すでにフォローしているかの確認
        $exist = $this->is_following($userId);
        //相手が自分自身であるかどうかの確認
        $its_me = $this->id == $userId;
         
        if($exist && !$its_me){
             //すでにフォローしていればフォローを外す
            $this->followings()->detach($userId);
            return true;
        }else{
            //未フォローであれば何もしない
            return false;
        }
     }
    /**
    * 指定された $userIdのユーザをこのユーザがフォロー中であるか調べる。フォロー中ならtrueを返す。
    *
    * @param  int  $userId
    * @return bool
    */
    
    public function is_following($userId){
     
    //フォロー中のユーザーの中に、$userIdのものが存在するか
    return $this->followings()->where('follow_id',$userId)->exists();
    }
     
    /**
     * このユーザとフォロー中ユーザの投稿に絞り込む。
     */
     public function feed_microposts(){
         //このユーザがフォロー中のユーザのidを取得して配列にする
         $userIds = $this->followings()->pluck('users.id')->toArray();
         
         //このユーザのidもその列に追加
         $userIds[] = $this->id;
         
         //それらのユーザが所有する投稿に絞り込む
         return Micropost::whereIn('user_id',$userIds);
     }
     
         public function favorite($micropostsId){
        
        // すでにお気に入り登録しているかの確認
        $exist = $this->is_favorite($micropostsId);
        //自分のツイートでないか確認
        $its_me = $this->id == $micropostsId;
        
        if($exist || $its_me){
            // すでにお気に入り登録していれば何もしない
            return false;
        }else{
            //お気に入り登録していなければお気に入り登録する
            $this->favorites()->attach($micropostsId);
            return true;
        }
    }
    
   /**
     * $micropostsIdで指定されたツイートをお気に入り登録する。
     *
     * @param  int  $micropostsId
     * @return bool
     */
     
     public function unfavorite($micropostsId){
         
        // すでにお気に入り登録しているかの確認
        $exist = $this->is_favorite($micropostsId);
        //自分のツイートでないか確認
        $its_me = $this->id == $micropostsId;
         
        if($exist && !$its_me){
             //すでにお気に入り登録していればお気に入り登録を外す
            $this->favorites()->detach($micropostsId);
            return true;
        }else{
            //お気に入り登録されてなければ何もしない
            return false;
        }
     }
    /**
    * 指定された $userIdのユーザをこのユーザがフォロー中であるか調べる。フォロー中ならtrueを返す。
    *
    * @param  int  $userId
    * @return bool
    */
    
    public function is_favorite($micropostsId){
     
    //お気に入り登録中のツイートの中に、$micropostsIdのものが存在するか
    return $this->favorites()->where('micropost_id',$micropostsId)->exists();
    }
     
}
