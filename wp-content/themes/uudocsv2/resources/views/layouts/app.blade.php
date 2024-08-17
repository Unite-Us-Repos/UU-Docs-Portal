<a class="sr-only focus:not-sr-only" href="#main">
  {{ __('Skip to content') }}
</a>

<div id="main-wrapper">
  @include('sections.header')
  @include('sections.sidebar')

  <main id="main" class="main lg:pl-72 py-8">
    @if (!$isLoggedIn && !is_404())
      @include('partials.content-login')
    @else
      @yield('content')
    @endif
  </main>
</div>

@include('sections.footer')

