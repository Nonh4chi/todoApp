<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Mail\ResetPassword;
use Illuminate\Support\Facades\Mail;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function folders()
    {
        return $this->hasMany('App\Models\Folder');
    }

    // public function sendPasswordResetNotification($token)
    // {
    //     Mail::to($this)->send(new ResetPassword($token));
    // }

    // /**
    //  * JWT の subject claim となる識別子を取得する
    //  *
    //  * @return mixed
     
    // public function getJWTIdentifier()
    // {
    //     return $this->getKey();
    // }

    
    //  * キーバリュー値を返します, JWTに追加される custom claims を含む
    //  *
    //  * @return array
    //  */
    // public function getJWTCustomClaims()
    // {
    //     return [];
    // }
     

}
