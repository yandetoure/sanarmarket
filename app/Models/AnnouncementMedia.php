<?php declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AnnouncementMedia extends Model
{
    public const TYPE_IMAGE = 'image';
    public const TYPE_VIDEO = 'video';

    protected $fillable = [
        'announcement_id',
        'path',
        'type',
        'position',
    ];

    public function announcement(): BelongsTo
    {
        return $this->belongsTo(Announcement::class);
    }

    public function getUrlAttribute(): string
    {
        return asset('storage/' . $this->path);
    }

    public function isImage(): bool
    {
        return $this->type === self::TYPE_IMAGE;
    }

    public function isVideo(): bool
    {
        return $this->type === self::TYPE_VIDEO;
    }
}


