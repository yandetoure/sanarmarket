<?php declare(strict_types=1);

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\ForumThread;
use App\Models\ForumReply;
use App\Models\ForumGroup;
use App\Models\ForumGroupMembership;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    // use Spatie\Permission\Traits\HasRoles; // Décommenter une fois le package Spatie installé

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_premium',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_premium' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    public function announcements(): HasMany
    {
        return $this->hasMany(Announcement::class);
    }

    public function boutiques(): HasMany
    {
        return $this->hasMany(Boutique::class);
    }

    public function restaurants(): HasMany
    {
        return $this->hasMany(Restaurant::class);
    }

    public function forumThreads(): HasMany
    {
        return $this->hasMany(ForumThread::class);
    }

    public function forumReplies(): HasMany
    {
        return $this->hasMany(ForumReply::class);
    }

    public function forumGroups(): BelongsToMany
    {
        return $this->belongsToMany(ForumGroup::class, 'forum_group_memberships', 'user_id', 'group_id')
            ->withPivot(['role', 'status'])
            ->wherePivot('status', ForumGroupMembership::STATUS_ACTIVE)
            ->withTimestamps();
    }

    public function forumGroupMemberships(): HasMany
    {
        return $this->hasMany(ForumGroupMembership::class);
    }

    public function campusSpotlights(): HasMany
    {
        return $this->hasMany(CampusSpotlight::class);
    }

    public function campusRestaurantMenus(): HasMany
    {
        return $this->hasMany(CampusRestaurantMenu::class);
    }

    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }

    public function usefulInfos(): HasMany
    {
        return $this->hasMany(UsefulInfo::class);
    }

    public const ROLE_USER = 'user';
    public const ROLE_ADMIN = 'admin';
    public const ROLE_AMBASSADOR = 'ambassador';
    public const ROLE_MODERATOR = 'moderator';

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    /**
     * Check if user is ambassador
     */
    public function isAmbassador(): bool
    {
        return $this->role === self::ROLE_AMBASSADOR || $this->isAdmin();
    }

    /**
     * Check if user is moderator
     */
    public function isModerator(): bool
    {
        return $this->role === self::ROLE_MODERATOR || $this->isAdmin();
    }

    /**
     * Check if user is designer
     */
    public function isDesigner(): bool
    {
        return $this->role === 'designer';
    }

    /**
     * Check if user is marketing
     */
    public function isMarketing(): bool
    {
        return $this->role === 'marketing';
    }

    public function activeSubscription()
    {
        return $this->hasOne(UserSubscription::class)->latestOfMany()
            ->where('status', 'active')
            ->where('ends_at', '>', now());
    }

    /**
     * Check if user is premium
     */
    public function isPremium(): bool
    {
        return $this->activeSubscription()->exists();
    }

    /**
     * Default media upload limit per announcement based on role
     */
    public function mediaUploadLimit(): int
    {
        if ($this->isAdmin()) {
            return 10;
        }

        $subscription = $this->activeSubscription;
        if ($subscription) {
            return $subscription->plan->max_photos_per_announcement;
        }

        return 3;
    }

    /**
     * Max announcements allowed
     */
    public function maxAnnouncementsLimit(): int
    {
        if ($this->isAdmin()) {
            return 999;
        }

        $subscription = $this->activeSubscription;
        if ($subscription) {
            return $subscription->plan->max_announcements;
        }

        return 3;
    }

    /**
     * Determine if the user can upload videos to announcements
     */
    public function canUploadVideo(): bool
    {
        return $this->isPremium() || $this->isAdmin();
    }

    /**
     * Check if user is active
     */
    public function isActive(): bool
    {
        return $this->is_active;
    }

    /**
     * Check if user can manage announcements
     */
    public function canManageAnnouncements(): bool
    {
        return $this->isAdmin();
    }

    /**
     * Get role label
     */
    public function getRoleLabelAttribute(): string
    {
        return match ($this->role) {
            self::ROLE_ADMIN => 'Admin',
            self::ROLE_AMBASSADOR => 'Ambassadeur',
            self::ROLE_MODERATOR => 'Modérateur',
            'designer' => 'Designer',
            'marketing' => 'Marketing',
            default => 'Utilisateur',
        };
    }

    /**
     * Get role color
     */
    public function getRoleColorAttribute(): string
    {
        return match ($this->role) {
            self::ROLE_ADMIN => 'bg-purple-100 text-purple-800',
            self::ROLE_AMBASSADOR => 'bg-blue-100 text-blue-800',
            'designer' => 'bg-pink-100 text-pink-800',
            'marketing' => 'bg-green-100 text-green-800',
            default => 'bg-slate-100 text-slate-800',
        };
    }

    /**
     * Get role label (helper method)
     */
    public function roleLabel(): string
    {
        return $this->getRoleLabelAttribute();
    }

    /**
     * Get role color class (helper method)
     */
    public function roleColorClass(): string
    {
        return $this->getRoleColorAttribute();
    }
}
