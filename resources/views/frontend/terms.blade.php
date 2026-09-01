@extends('layouts.front')

@section('meta_name'){{ $pages->meta_name }}@stop

@section('meta_description'){{ $pages->meta_description }}@stop

@section('meta_keyword'){{ $pages->meta_keyword }}@stop

@section('content')

<div class="terms-condition">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <h1 class="term-title">{{ $pages->name }}</h1>
                {!! $pages->details !!}
            </div>
        </div>
    </div>
</div>

@endsection