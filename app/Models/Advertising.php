<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Advertising extends Model
{
    
    protected $fillable=['link','title','price','area','details','finishing','rooms','floor','type','supplier_name','phone','supplier_advertisings_count','website_name','advertisings_date','pagelink_id','images','aqar_type','supplier_count_ads','address'];
}
