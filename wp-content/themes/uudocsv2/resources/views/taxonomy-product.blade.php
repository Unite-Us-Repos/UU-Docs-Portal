@php
if (!is_array($acf)) {
  $acf = [];
}
@endphp
@extends('layouts.app')

@section('content')
    @includeFirst(['partials.product-archive', 'partials.content'], $acf)
@endsection
