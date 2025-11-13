<?php declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\ForumGroupMembership;

class ForumGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'rules',
        'cover_image',
        'is_private',
        'owner_id',
    ];

    protected $casts = [
        'is_private' => 'boolean',
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function threads(): HasMany
    {
        return $this->hasMany(ForumThread::class, 'group_id');
    }

    public function memberships(): HasMany
    {
        return $this->hasMany(ForumGroupMembership::class, 'group_id');
    }

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'forum_group_memberships', 'group_id', 'user_id')
            ->withPivot(['role', 'status'])
            ->wherePivot('status', ForumGroupMembership::STATUS_ACTIVE)
            ->withTimestamps();
    }

    public function bannedMembers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'forum_group_memberships', 'group_id', 'user_id')
            ->withPivot(['role', 'status'])
            ->wherePivot('status', 'banned')
            ->withTimestamps();
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}

