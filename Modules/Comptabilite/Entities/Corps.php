<?php

namespace Modules\Comptabilite\Entities;

use Modules\Acl\Entities\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Corps extends Model
{
    protected $guarded = [];
    use HasFactory, SoftDeletes;
 
    // public function ecritures()
    // {
    //     return $this->hasMany(Ecriture::class)->orderby('created_at', 'DESC');
    // } 
 
    public function morgue()
    {
        return $this->belongsTo(Morgue::class, 'morgue_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function examens()
    {
        return $this->hasMany(Examen::class);
    }

    public function autorisations()
    {
        return $this->hasMany(Autorisation::class);
    }

    public function mouvements()
    {
        return $this->hasMany(Mouvement::class);
    }
}
