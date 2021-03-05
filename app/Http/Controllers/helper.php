<?php

if (!function_exists('get_before_folder_url')) {

	function get_before_folder_url($id) {

		$id= \App\Models\Archieve::find($id)->parent_id;
		if ($folder=\App\Models\Archieve::find($id)) {
			return 	route('show_folder_back',$folder->name );
		}else{
			return route('index_archeive');
		}

	}

}

if (!function_exists('get_current_folder_path')) {

	function get_current_folder_path($id) {

		//$id= \App\Models\Archieve::find($id)->parent_id;
		if ($folder=\App\Models\Archieve::find($id)) {
			return 	$folder->path;
		}else{
			return '';
		}

	}

}

if (!function_exists('get_back_folder_path')) {

	function get_back_folder_path() {

		$id= \App\Models\Archieve::find(session()->get('folder_id'))->parent_id;
		if ($folder=\App\Models\Archieve::find($id)) {
			return url("/view-folder/?path=".$folder->path) ;
		}else{
			return route('index_archeive');
		}

	}

}


if (!function_exists('myName')) {

	function myName($id)
	    {
	    	if ($folder=\App\Models\Archieve::find($id)) {
	    		return $folder->name;
	    	}
	    	
	    }

	

}

if (!function_exists('isChildOrNot')) {

	function isChildOrNot($parent_archeive,$name)
	    {
	    	$childs=\App\Models\Archieve::where('parent_id',$parent_archeive->id)->where('name',$name)->get();
	    	if (count($childs)) {
	    		return true;
	    	}
	    	return false;
	    }

	

}

if (!function_exists('path_array')) {

	function path_array()
	    {
	    	if(session()->get('folder_id')==0){
	    		return [];
	    	}else{
	    		$current_folder=\App\Models\Archieve::find(session()->get('folder_id'));
	    		$path=str_replace("app/Ainshams/","",$current_folder->path);
		    	$folders=explode('/', $path);
		    	return $folders;
	    	}
		    	
	    }

	

}

if (!function_exists('helperCopy')) {

	function helperCopy($new_id,$old_id)
    {
    	$old_archeive=\App\Models\Archieve::find($old_id);
    	$new_archeive=\App\Models\Archieve::find($new_id);

    	foreach ($old_archeive->myChildren as $child) {

    		$archieve=new \App\Models\Archieve();
    		$archieve->name=$child->name;
    		$archieve->type=$child->type;
    		$archieve->extension=$child->extension;
    		$archieve->parent_id=$new_id;
    		$archieve->path=$new_archeive->path . '/' . $child->name;
    		$archieve->save();

    		//dd($archieve->path);
    		
    		if ($child->type=='file') {
    			\File::copy(storage_path('app/'.$child->path), storage_path('app/'.$archieve->path));

    		}else{
    			\Storage::disk('local')->makeDirectory($archieve->path);
    			helperCopy($archieve->id,$child->id);
    		}
    	}
    }
}

if (!function_exists('helperCut')) {

	function helperCut($new_id,$old_id)
    {
    	$old_archeive=\App\Models\Archieve::find($old_id);
    	$new_archeive=\App\Models\Archieve::find($new_id);

    	foreach ($old_archeive->myChildren as $child) {

    		$archieve=new \App\Models\Archieve();
    		$archieve->name=$child->name;
    		$archieve->type=$child->type;
    		$archieve->extension=$child->extension;
    		$archieve->parent_id=$new_id;
    		$archieve->path=$new_archeive->path . '/' . $child->name;
    		$archieve->save();

    		//dd($archieve->path);
    		
    		if ($child->type=='file') {
    			\File::move(storage_path('app/'.$child->path), storage_path('app/'.$archieve->path));

    		}else{
    			\Storage::disk('local')->makeDirectory($archieve->path);
    			helperCut($archieve->id,$child->id);
    			
    		}
    	}
    }
}

if (!function_exists('helperRemove')) {

	function helperRemove($old_id)
    {
    	$old_archeive=\App\Models\Archieve::find($old_id);

    	foreach ($old_archeive->myChildren as $child) {
    		
    		if ($child->type=='file') {

    			\File::delete(storage_path('app/'.$child->path));

    		}else{

    			helperRemove($child->id);
    			
    		}

    		$child->delete();
    	}
    }
}








if (!function_exists('active_menu')) {

	function active_menu($key) {

		if (is_array($key)) {

			if (in_array(Request::segment(1),$key) ) {
				return 'active selected';
			}
		}

	}

}

if (!function_exists('active_link')) {

	function active_link($key) {

		if (!is_array($key)) {

			if (Request::segment(1) == $key) {
				return 'current-page';
			}
		} 

	}

}


if(!function_exists('v_image')){
	function v_image($ext=null){
		if ($ext===null) {
			return 'mimes:jpg,JPG,jpeg,JPEG,png,PNG,gif,GIF';
		}else{
			return 'image|mimes:' . $ext;
 		}
	}
}
if (!function_exists('image_upload')){
	function image_upload($file,$type,$image_name=null)
	{
		$image_name=md5 (microtime()) . '.' . $file->getClientOriginalExtension();
		$file->move(public_path('upload/'.$type),$image_name);
		 return $image_name;
	}
}

if (!function_exists('get_string_between')){
	function get_string_between($string, $start, $end){
	    $string = ' ' . $string;
	    $ini = strpos($string, $start);
	    if ($ini == 0) return '';
	    $ini += strlen($start);
	    $len = strpos($string, $end, $ini) - $ini;
	    return substr($string, $ini, $len);
	}
}

if (!function_exists('get_olx_phone_number')){
	function get_olx_phone_number($id){
	    $url='https://www.olx.com.eg/ajax/misc/contact/phone/'.$id.'/';

		$ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POST, true);
        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        
        $result = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($result);
        if ($result != null) {
        	return str_replace(" ", "", $result->value) ;
        }
        return null;


	}
}


if (!function_exists('is_super_admin')){
	function is_super_admin(){
	    if (auth()->user()->hasRole('super-admin')) {
	    	return true;
	    }
	    return false;
	}
}

if (!function_exists('valid_month')){
	function valid_month($month){
	    if ($month=='يناير') {
	    	return 1;
	    }
	    if ($month=='فبراير'||$month=='فبراير ') {
	    	return 2;
	    }
	    if ($month=='مارس') {
	    	return 3;
	    }
	    if ($month=='أبريل') {
	    	return 4;
	    }
	    if ($month=='مايو') {
	    	return 5;
	    }
	    if ($month=='يونيه') {
	    	return 6;
	    }
	    if ($month=='يوليو') {
	    	return 7;
	    }
	    if ($month=='أغسطس') {
	    	return 8;
	    }
	    if ($month=='سبتمبر') {
	    	return 9;
	    }
	    if ($month=='أكتوبر') {
	    	return 10;
	    }
	    if ($month=='نوفمبر') {
	    	return 11;
	    }
	    if ($month=='ديسمبر') {
	    	return 12;
	    }
	    
	}
}



if (!function_exists('get_valid_date_olx')){
	function get_valid_date_olx($date){
	    $time= substr($date, 0, 6);
	    $day = (int)substr($date, 6, 6);
	    $month = preg_replace('/\d+/u', '',substr($date, 9, 14));
	    $month=valid_month($month);
	    $year = (int)substr($date, 22, 23);
	    return date($time.'-'.$day.'-'.$month.'-'.$year);
	}
}





?>