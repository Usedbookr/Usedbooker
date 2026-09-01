

<ul>
	@if($books)
	@foreach($books as $key => $value)
	<li>
		<a href="{{ route('product.details',  [$value->categories->url_slug ?? '', $value->url_slug ?? '']) }}" class="d-block">{{ $value->name }}</a>
	</li>
	@endforeach
	@endif
</ul>