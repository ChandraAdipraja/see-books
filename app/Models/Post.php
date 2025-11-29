<?php

namespace App\Models;

use App\Models\Concerns\UsesUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory, UsesUuid;

    protected $fillable = ['user_id', 'title', 'slug', 'semester', 'course', 'meeting', 'body', 'is_public'];

    protected $casts = [
        'is_public' => 'boolean',
        'semester' => 'integer',
        'meeting' => 'integer',
    ];

    // relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // relasi ke images (nanti kita buat model PostImage)
    public function images()
    {
        return $this->hasMany(PostImage::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->latest();
    }
}
