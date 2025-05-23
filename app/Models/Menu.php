<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Menu extends Model
{
    protected $table = "menu";

    protected $primaryKey = "idMenu";

    protected $fillable = ["menuName", "menuType", "menuUrl", "menuTarget", "menuOrder", "menuParent", "isActive"];

    public function subMenus()
    {
        return $this->hasMany(Menu::class, 'menuParent', 'idMenu');
    }
}



?>