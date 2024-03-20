<?php

namespace Modules\Comptabilite\Entities;

use Modules\Acl\Entities\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mouvement extends Model
{
    protected $guarded = [];
    use HasFactory;
    protected $table = 'mouvement_corps';
    // public function ecritures()
    // {    
    //     return $this->hasMany(Ecriture::class)->orderby('created_at', 'DESC');
    // } 
 
    public function corps()
    {
        return $this->belongsTo(Corps::class, 'corps_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
