<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'username',
        'password',
        'full_name',
        'city',
        'phone_number',
        'role',
        'description',
        'profile_pic',
        'content_settings',
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

    public function bidang(){
        return $this->belongsToMany(Bidang::class, 'users_bidang', 'user_id', 'bidang_id');
    }

    public function interest(){
        return $this->belongsToMany(Categories::class, 'users_interest', 'user_id', 'category_id');
    }
    
    public function sosmed(){
        return $this->hasMany(Sosmed::class, 'user_id');
    }

    public function post(){
        return $this->hasMany(Post::class, 'user_id')->orderBy('created_at', 'desc');
    }
    
    public function tutoring(){
        return $this->hasMany(TutorSession::class, 'tutor_id');
    }
    
    public function pesertaTutor(){
        return $this->hasMany(PesertaTutoring::class, 'user_id');
    }
    
    public function ulasan(){
        return $this->hasMany(UlasanTutoring::class, 'user_id');
    }
    
    public function buktiTutor(){
        return $this->hasMany(BuktiTutoring::class, 'user_id');
    }


    
}
