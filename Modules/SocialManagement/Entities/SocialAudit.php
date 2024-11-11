<?php

namespace Modules\SocialManagement\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialAudit extends Model
{
    use HasFactory;

    protected $table = 'social_audits';

    protected $fillable = [
        'user_id',
        'business_id',
        'social_id',
        'social_audit_morning',
        'posted_morning',
        'social_note_morning',
        'social_audit_afternoon',
        'posted_afternoon',
        'social_note_afternoon',
    ];

    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }

    public function business()
    {
        return $this->belongsTo(\App\BusinessLocation::class);
    }

    public function social()
    {
        return $this->belongsTo(Social::class);
    }
}
