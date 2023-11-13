<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class project extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable = ['title', 'slug', 'cover_image', 'content', 'type_id'];

    // CHECK IF ALREADY EXISTS WHEN ADDING ENTRIES
    public function generateSlug($title)
    {
        return Str::slug($title, '-');
    }

    public function Type(): BelongsTo
    {
        return $this->belongsTo(Type::class);
    }
}
