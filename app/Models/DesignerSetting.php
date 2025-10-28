<?php declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DesignerSetting extends Model
{
    protected $fillable = [
        'user_id',
        'logo_path',
        'sidebar_bg_color',
        'sidebar_text_color',
        'sidebar_active_bg',
        'sidebar_active_text',
        'navbar_bg_color',
        'navbar_text_color',
        'navbar_accent_color',
        'primary_color',
        'secondary_color',
        'accent_color',
        'font_family',
        'font_size',
    ];

    protected $casts = [
        'font_size' => 'integer',
    ];

    /**
     * Relation avec l'utilisateur
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Obtenir l'URL du logo
     */
    public function getLogoUrlAttribute(): ?string
    {
        if ($this->logo_path) {
            return asset('storage/' . $this->logo_path);
        }
        return null;
    }

    /**
     * Récupérer ou créer les paramètres pour un utilisateur
     */
    public static function getForUser(int $userId): self
    {
        return static::firstOrCreate(
            ['user_id' => $userId],
            static::getDefaults()
        );
    }

    /**
     * Valeurs par défaut
     */
    public static function getDefaults(): array
    {
        return [
            'sidebar_bg_color' => '#ffffff',
            'sidebar_text_color' => '#374151',
            'sidebar_active_bg' => '#FCE7F3',
            'sidebar_active_text' => '#DB2777',
            'navbar_bg_color' => '#ffffff',
            'navbar_text_color' => '#111827',
            'navbar_accent_color' => '#EC4899',
            'primary_color' => '#EC4899',
            'secondary_color' => '#A855F7',
            'accent_color' => '#F472B6',
            'font_family' => 'Inter',
            'font_size' => 16,
        ];
    }
}