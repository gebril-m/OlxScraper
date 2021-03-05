<tr>
	<td><a href="{{url('/scraping/show/'.$advertising->id)}}" style="color: blue;">{{$advertising->title}}</a></td>
	<td><a href="call:+02{{$advertising->phone}}"><span class="icon-phone4"></span></a></td>
	<td><a href="https://wa.me/+02{{$advertising->phone}}"><span class="icon-bubble"></span></a></td>
	<td>{{$advertising->price}}</td>
	<td>{{$advertising->area}}</td>
	<td>{{$advertising->rooms}}</td>
	<td>{{$advertising->floor}}</td>
	<td>{{$advertising->type}}</td>
	<td>{{$advertising->advertisings_date}}</td>
	
</tr>