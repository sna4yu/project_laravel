<?php

namespace Modules\BusinessBackup\Entities;

use Illuminate\Database\Eloquent\Model;

class BusinessBackup extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'sheet_data' => 'array',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sheet_businessbackups';

    /**
     * user who created a sheet.
     */
    public function createdBy()
    {
        return $this->belongsTo('App\User', 'created_by');
    }

    public function shares()
    {
        return $this->hasMany(\Modules\BusinessBackup\Entities\BusinessBackupShare::class, 'sheet_businessbackup_id');
    }
}
