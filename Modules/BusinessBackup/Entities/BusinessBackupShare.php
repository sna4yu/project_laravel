<?php

namespace Modules\BusinessBackup\Entities;

use Illuminate\Database\Eloquent\Model;

class BusinessBackupShare extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sheet_businessbackup_shares';
}
