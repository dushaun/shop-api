<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * Get the Product slug as route key.
     *
     * @return mixed|string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
