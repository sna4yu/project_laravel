<?php

namespace Modules\SocialManagement\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Social extends Model
{
    use HasFactory;
    protected $table = 'social_table';

    protected $fillable = [
        'business_id',
        'asset_id',
        'name',
        'social_category_id',
        'description',
        'email',
        'password',
        'link',
        'assign_to',
        'created_by'
    ];
}
