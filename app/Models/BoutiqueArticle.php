<?php declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BoutiqueArticle extends Model
{
    use HasFactory;

    protected $fillable = [
        'boutique_id',
        'boutique_category_id',
        'name',
        'slug',
        'description',
        'price',
        'stock',
        'status',
        'image',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public function boutique(): BelongsTo
    {
        return $this->belongsTo(Boutique::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(BoutiqueCategory::class, 'boutique_category_id');
    }
}

