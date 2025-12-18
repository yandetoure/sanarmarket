<?php declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UsefulInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'title',
        'content',
        'data',
        'image',
        'user_id',
        'is_active',
    ];

    protected $casts = [
        'data' => 'array',
        'is_active' => 'boolean',
    ];

    public const TYPE_PRAYER_TIMES = 'prayer_times';
    public const TYPE_UNIVERSITY_CONTACT = 'university_contact';
    public const TYPE_PHARMACY_ON_DUTY = 'pharmacy_on_duty';
    public const TYPE_CAMPUS_MAP = 'campus_map';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
