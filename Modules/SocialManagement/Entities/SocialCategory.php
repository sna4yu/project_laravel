<?php

namespace Modules\SocialManagement\Entities;

use Illuminate\Database\Eloquent\Model;

class SocialCategory extends Model
{
    protected $fillable = ['name', 'description'];

    protected $table = 'social_categories';

    public static function forDropdown($business_id)
    {
        $categories = self::where('business_id', $business_id)
            ->pluck('name', 'id');

        return $categories->toArray();
    }
}
