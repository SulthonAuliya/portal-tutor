<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'Post';


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'img_url',
        'video_url',
        'description',
    ];

    public function categories(){
        return $this->belongsToMany(Categories::class, 'post_categories', 'post_id', 'category_id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function tutorSession(){
        return $this->hasMany(TutorSession::class, 'post_id');
    }
}
