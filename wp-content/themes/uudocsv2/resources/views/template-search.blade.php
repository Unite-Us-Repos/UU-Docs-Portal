{{--
  Template Name: Search
--}}

@extends('layouts.app')

@section('content')


<header class="component-inner-section pt-6">
    <div class="border-b border-pale-blue mb-10 flex flex-col md:grid md:grid-cols-12 md:gap-12">
      <div class="col-span-10">
        <div class="uppercase text-base font-semibold mb-6">
            <a class="no-underline" href="/search-results/">Search Results</a>
        </div>
        <h1 class="p-name text-4xl mb-6">
          Search Results
        </h1>
      </div>
      <div class="col-span-2">
        @if (has_post_thumbnail())
          <div>
            <img class="mx-auto"
              src="{{ get_the_post_thumbnail_url( get_the_ID(), 'full') }}"
              alt="" />
          </div>
        @endif
      </div>
    </div>
  </header>


  <section id="kh-top" class="component-section">
    <div class="component-inner-section">
      <div id="ajax-filters" class="search-filters relative z-40 mb-9">
        @php
          echo do_shortcode('[searchandfilter slug="site-search"]');
        @endphp
      </div>

      <div id="kb-search-results">
        {!! do_shortcode('[searchandfilter slug="site-search" show="results"]') !!}
      </div>
    </div>
  </section>
@endsection
<script>
jQuery().ready(function($) {
  $(document).on("sf:ajaxfinish", ".searchandfilter", function() {
    lazyLoadInstance.update(); // refresh lazy loading on ajax call
  });
});
</script>
