<?php declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'icon',
        'description',
    ];

    public function announcements(): HasMany
    {
        return $this->hasMany(Announcement::class);
    }
}
