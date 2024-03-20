<?php

namespace Modules\Comptabilite\Entities;

use Modules\Acl\Entities\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ligne extends Model
{
    protected $guarded = [];
    use HasFactory, SoftDeletes;
 
    public function ecritures()
    {
        return $this->hasMany(Ecriture::class)->orderby('created_at', 'DESC');
    }

    public function budget()
    {
        return $this->belongsTo(Budget::class, 'budget_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
