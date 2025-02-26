<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'parent_id'];

    // Relationship to parent category
    public function parent()
    {
        return $this->belongsTo(ForumCategory::class, 'parent_id');
    }

    // Relationship to child categories (subcategories)
    public function children()
    {
        return $this->hasMany(ForumCategory::class, 'parent_id');
    }

    // Relationship to posts
    public function posts()
    {
        return $this->hasMany(ForumPost::class);
    }
}
