{{--
  Template Name: Release Notes
--}}

@extends('layouts.app')

@section('content')
  @while(have_posts()) @php(the_post())
    @include('partials.content-release-notes')
  @endwhile
@endsection
