@extends('layouts.404')
@section('content')
<section class="component-section">
  <div class="component-inner-section">
    <div class="md:relative flex flex-col lg:grid lg:grid-cols-2 gap-10">

      <div class="flex flex-col lg:col-span-1 order-2 text-lg lg:order-1 ">
        <div class="subtitle">404</div>
          <h2>Oops!</h2>

          <div class="description">
            <p>We can’t find the page you were looking for. Sorry about that!</p>
        </div>

        <div class="flex flex-wrap justify-center flex-col sm:flex-row gap-6  mt-5  button-layout-text grid grid-cols-2 gap-x-6 lg:justify-start">
          <div class="mt-10">
            <a href="{{ home_url() }}" class="button button-hollow flex-1 gap-2">
              Homepage
              <span aria-hidden="true"> →</span>
            </a>
        </div>

          </div>
      </div>

      <div class="flex flex-col lg:col-span-1  relative  lg:order-2 ">
        <img class="lazy rounded-lg w-full max-w-md mx-auto lg:max-w-3xl entered loaded" alt="404 not found magnifying glass" src="@asset('/images/404-not-found.png')">
      </div>
    </div>
  </div>
</section>
@endsection
