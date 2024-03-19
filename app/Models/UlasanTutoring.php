<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UlasanTutoring extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ulasan_tutoring';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'tutoring_id',
        'description',
        'rating',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function tutoring(){
        return $this->belongsTo(TutorSession::class, 'tutoring_id');
    }
}
