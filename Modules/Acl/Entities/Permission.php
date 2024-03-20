<?php

namespace Modules\Acl\Entities;

//use Backpack\CRUD\app\Models\Traits\CrudTrait;

class Permission extends \Spatie\Permission\Models\Permission
{
//    use CrudTrait;
    use \Spatie\Translatable\HasTranslations;

    protected $fillable = ['uuid', 'name', 'display_name', 'guard_name', 'updated_at', 'created_at'];
    protected $translatable = ['display_name'];
    
}
