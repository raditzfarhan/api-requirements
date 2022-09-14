<?php

namespace App\Filters;

use Laraditz\ModelFilter\Filter;
use Illuminate\Database\Eloquent\Builder;

class ProductFilter extends Filter
{
    public function sku(string $sku): void
    {
        $this->where('sku', $sku);
    }

    public function name(string $name): void
    {
        $this->where('name', 'LIKE', "%$name%");
    }

    public function category(string $category): void
    {
        $this->where('category', $category);
    }

    public function price(int|string $price): void
    {
        $prices = explode(',', $price);
        if (count($prices) === 2) {
            $this->whereBetween('price', $prices);
        } elseif (count($prices) === 1) {
            $this->where('price', $prices[0]);
        }
    }
}
