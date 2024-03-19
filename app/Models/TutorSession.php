<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TutorSession extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tutor_session';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'tutor_id',
        'post_id',
        'start_time',
        'end_time',
        'invitation_code',
        'status',
    ];

    public function pesertaTutor(){
        return $this->hasMany(PesertaTutoring::class, 'tutoring_id');
    }

    public function buktiTutor(){
        return $this->hasMany(BuktiTutoring::class, 'tutoring_id');
    }

    public function ulasan(){
        return $this->hasMany(UlasanTutoring::class, 'tutoring_id');
    }

    public function post(){
        return $this->belongsTo(Post::class, 'post_id');
    }
}
