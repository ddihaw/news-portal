<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $table = "category";

    protected $primaryKey = "idCategory";

    protected $fillable = ["nameCategory"];
    public function news(): HasMany
    {
       return $this->hasMany(News::class, 'idCategory', 'idCategory');
    }
}



?>