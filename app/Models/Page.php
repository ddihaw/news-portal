<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $table = "page";

    protected $primaryKey = "idPage";

    protected $fillable = ["pageTitle", "pageContent", "isActive"];
}

?>