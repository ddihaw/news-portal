<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $table = "news";

    protected $primaryKey = "idNews";

    protected $fillable = ["newsTitle", "newsContent", "newsImage", "idCategory"];

    public function category()
    {
        return $this->belongsTo(Category::class, 'idCategory');
    }
}

?>