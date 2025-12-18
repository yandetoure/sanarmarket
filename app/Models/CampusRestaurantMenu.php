<?php declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Modèle pour les menus des restaurants du campus (Restau 1, Restau 2)
 * Ce sont des restaurants universitaires, différents des restaurants commerciaux
 */
class CampusRestaurantMenu extends Model
{
    use HasFactory;

    protected $table = 'campus_restaurant_menus';

    protected $fillable = [
        'restaurant_name',
        'meal_type',
        'menu_content',
        'menu_date',
        'opening_time',
        'closing_time',
        'user_id',
    ];

    protected $casts = [
        'menu_date' => 'date',
        'opening_time' => 'datetime',
        'closing_time' => 'datetime',
    ];

    public const RESTAURANT_1 = 'Restau 1';
    public const RESTAURANT_2 = 'Restau 2';

    public const MEAL_DEJEUNER = 'dejeuner';
    public const MEAL_DINER = 'diner';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
