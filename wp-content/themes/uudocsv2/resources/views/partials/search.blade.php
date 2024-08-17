@extends('layouts.app')

@section('content')
<section class="component-section bg-dark">
  <div class="component-inner-section text-white text-center">
    @include('partials.page-header')
  </div>
</section>

<section class="component-section">
  <div class="component-inner-section">
  @if (! have_posts())
    <x-alert type="warning">
      {!! __('Sorry, no results were found.', 'sage') !!}
    </x-alert>

    {!! get_search_form(false) !!}
  @endif

  @while(have_posts()) @php(the_post())
    @include('partials.content-search')
  @endwhile

  @if (function_exists('wp_pagenavi'))
    {!! wp_pagenavi() !!}
  @else
    {!! get_the_posts_navigation() !!}
  @endif
  </div>
</section>
@endsection

