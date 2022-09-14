<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laraditz\ModelFilter\Filterable;

class Product extends Model
{
    use HasFactory, Filterable;

    protected $fillable = ['sku', 'name', 'category', 'price'];

    /**
     * Get the price list
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function priceList(): Attribute
    {
        return Attribute::make(
            get: fn () => [
                'original' => $this->original_price,
                'final' => $this->final_price,
                'discount_percentage' => $this->discount_percentage ? $this->discount_percentage . '%' : null,
                'currency' => $this->currency,
            ]
        );
    }

    /**
     * Get the original price 
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function originalPrice(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->price
        );
    }

    /**
     * Get the final price 
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function finalPrice(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->discount_percentage > 0 ? $this->price - ($this->price * ($this->discount_percentage / 100)) : $this->price
        );
    }

    /**
     * Get the discount percentage
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function discountPercentage(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->category === 'insurance' ? 30 : ($this->sku === '000003' ? 15 : null),
        );
    }

    /**
     * Get the currency
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function currency(): Attribute
    {
        return Attribute::make(
            get: fn () => config('params.currency')
        );
    }
}
