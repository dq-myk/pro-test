<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'post_code',
        'address',
        'building',
        'image_path',
        'first_login',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // コメントとのリレーション (1対多)
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // 購入履歴とのリレーション (1対多)
    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    // 出品情報とのリレーション (1対多)
    public function sells()
    {
        return $this->hasMany(Sell::class);
    }

    // いいね情報とのリレーション (1対多)
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    // 取引(購入）とのリレーション（1対多）
    public function boughtTransactions() {
        return $this->hasMany(Transaction::class, 'buyer_id');
    }

    // 取引(出品）とのリレーション（1対多）
    public function soldTransactions() {
        return $this->hasMany(Transaction::class, 'seller_id');
    }

    // チャットメッセージとのリレーション（1対多）
    public function messages() {
        return $this->hasMany(Message::class, 'sender_id');
    }

    // 評価をしたユーザー（購入者）とのリレーション
    public function reviewsGiven()
    {
        return $this->hasMany(UserReview::class, 'reviewer_id');
    }

    // 評価を受けたユーザー（出品者）とのリレーション
    public function reviewsReceived()
    {
        return $this->hasMany(UserReview::class, 'reviewee_id');
    }

}
