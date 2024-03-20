<?php

namespace Modules\Comptabilite\Entities;

use Modules\Acl\Entities\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Saccount extends Model
{
    protected $guarded = [];
    use HasFactory, SoftDeletes;
    
    public function saccountclass(){
        return $this->belongsTo(SaccountClass::class, 'saccount_class_id');
    }
    
    public function saccount(){
        return $this->belongsTo(Saccount::class, 'parent_id', 'num');
    }
    
    public function journaux_debit(){
        return $this->hasMany(Journal::class, 'compte_debit_id')->orderby('created_at', 'DESC');
    }
    
    public function journaux_credit(){
        return $this->hasMany(Journal::class, 'compte_debit_id')->orderby('created_at', 'DESC');
    }
    
    public function ecritures_debit(){
        return $this->hasMany(Ecriture::class, 'compte_debit_id')->orderby('created_at', 'DESC');
    }
    
    public function ecritures_credit(){
        return $this->hasMany(Ecriture::class, 'compte_debit_id')->orderby('created_at', 'DESC');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
