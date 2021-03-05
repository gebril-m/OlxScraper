<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pagelink extends Model
{
    protected $fillable=['url','title','tab_id'];

    public function advertisings()
    {
    	return $this->hasMany(Advertising::class);
    }
}
