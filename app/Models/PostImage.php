<?php

namespace App\Models;

use App\Models\Concerns\UsesUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostImage extends Model
{
    use HasFactory, UsesUuid;

    protected $fillable = [
        'post_id',
        'path',
        'order',
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
