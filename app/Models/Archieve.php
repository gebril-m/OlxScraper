<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Archieve extends Model
{
    protected $fillable = ['name','type','size','path','parent_id','extension'];

    public function myParent(){
    	return Archieve::find('id',$this->parent_id);
    }

    public function myChildren(){
    	return $this->hasMany(Archieve::class,'parent_id','id');
    }

    public function copy($new_id,$old_id)
    {
    	$old_archeive=Archieve::find($old_id);
    	foreach ($old_archeive->myChildren as $child) {
    		$archieve=new Archieve();
    		$archieve->fill($child);
    		$archieve->parent_id=$new_id;
    		$archieve->save();
    	}
    }
}
