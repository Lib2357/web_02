<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'sv23810310276_products';

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'stock_quantity',
        'image_path',
        'status',
        'discount_percent',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'discount_percent' => 'integer',
        'stock_quantity' => 'integer',
    ];

    protected static function booted(): void
    {
        static::saving(function (Product $product): void {
            if ($product->stock_quantity <= 0) {
                $product->status = 'out_of_stock';
            }
        });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    protected function discountedPrice(): Attribute
    {
        return Attribute::get(function (): float {
            $discount = max(0, min(100, (int) $this->discount_percent));
            $price = (float) $this->price;

            return round($price * (100 - $discount) / 100, 2);
        });
    }
}
