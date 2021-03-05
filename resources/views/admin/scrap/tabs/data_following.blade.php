
<select class="form-control" id="checker" style="width: 64%;" onchange="change_following($(this),'{{$adversing->id}}')">
	<option disabled="disabled" selected>following</option>
	<option value="phone_later" @if($adversing->following=='phone_later') 'selected' @endif >phone_later</option>
	<option value="phone_done" @if($adversing->following=='phone_done') 'selected' @endif>phone_done</option>
	<option value="closed" @if($adversing->following=='closed') 'selected' @endif >closed</option>
	<option value="office" @if($adversing->following=='office') 'selected' @endif>office</option>
	
</select>
										
							