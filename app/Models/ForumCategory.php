<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ForumPost;

class ForumCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    public function posts()
    {
        return $this->hasMany(ForumPost::class);
    }
}
