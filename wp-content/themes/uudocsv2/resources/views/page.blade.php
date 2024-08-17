@extends('layouts.app')

@section('content')
  @while(have_posts()) @php(the_post())
    <div class="component-section">
      <div class="component-inner-section">
        @include('partials.page-header')
        @includeFirst(['partials.content-page', 'partials.content'])
      </div>
    </section>
  @endwhile
@endsection
