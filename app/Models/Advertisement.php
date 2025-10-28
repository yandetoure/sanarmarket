<?php declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Advertisement extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image',
        'link',
        'type',
        'position',
        'display_duration',
        'popup_duration',
        'is_active',
        'start_date',
        'end_date',
        'designer_id',
        'category_id',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    /**
     * Scope pour les publicités actives
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Catégorie de la publicité
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Designer propriétaire
     */
    public function designer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'designer_id');
    }

    /**
     * Scope pour les publicités en cours de diffusion
     */
    public function scopeCurrentlyActive($query)
    {
        $now = Carbon::now();
        return $query->where('is_active', true)
            ->where(function ($q) use ($now) {
                $q->whereNull('start_date')
                  ->orWhere('start_date', '<=', $now);
            })
            ->where(function ($q) use ($now) {
                $q->whereNull('end_date')
                  ->orWhere('end_date', '>=', $now);
            });
    }

    /**
     * Scope pour les bannières hero
     */
    public function scopeHeroBanners($query)
    {
        return $query->where('position', 'hero')->where('type', 'banner');
    }

    /**
     * Scope pour les popups
     */
    public function scopePopups($query)
    {
        return $query->where('type', 'popup');
    }

    /**
     * Vérifier si la publicité est actuellement visible
     */
    public function isCurrentlyVisible(): bool
    {
        if (!$this->is_active) {
            return false;
        }

        $now = Carbon::now();

        if ($this->start_date && $this->start_date > $now) {
            return false;
        }

        if ($this->end_date && $this->end_date < $now) {
            return false;
        }

        return true;
    }

    /**
     * Obtenir l'URL de l'image
     */
    public function getImageUrlAttribute(): ?string
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        return null;
    }

    /**
     * Obtenir la durée d'affichage formatée
     */
    public function getFormattedDurationAttribute(): string
    {
        if ($this->type === 'popup' && $this->popup_duration) {
            return $this->popup_duration . ' secondes';
        }
        
        return $this->display_duration . ' jours';
    }
}