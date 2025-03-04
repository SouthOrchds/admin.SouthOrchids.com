<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin_permission extends Model
{
    protected $table = 'admin_permissions';
    public $timestamps = false;
    public $incrementing = false;
    protected $primaryKey = 'admin_id';
    protected $guarded = [];

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id', 'id');
    }
}
