<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $table = "news";

    protected $primaryKey = "idNews";

    protected $fillable = ["newsTitle", "newsContent", "newsImage", "idCategory", "totalViews"];

    public function category()
    {
        return $this->belongsTo(Category::class, 'idCategory');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'idAuthor');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'idNews');
    }

}

?>