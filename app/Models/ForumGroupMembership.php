<?php declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ForumGroupMembership extends Model
{
    use HasFactory;

    public const STATUS_ACTIVE = 'active';
    public const STATUS_BANNED = 'banned';

    protected $fillable = [
        'group_id',
        'user_id',
        'role',
        'status',
    ];

    protected $casts = [
        'status' => 'string',
    ];

    public function group(): BelongsTo
    {
        return $this->belongsTo(ForumGroup::class, 'group_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

