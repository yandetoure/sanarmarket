<?php declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BoutiqueCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'boutique_id',
        'name',
        'slug',
        'description',
    ];

    public function boutique(): BelongsTo
    {
        return $this->belongsTo(Boutique::class);
    }

    public function articles(): HasMany
    {
        return $this->hasMany(BoutiqueArticle::class);
    }
}

