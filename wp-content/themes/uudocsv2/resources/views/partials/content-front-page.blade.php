@php
$title = isset($acf['hero']['title']) ? $acf['hero']['title'] : '';
$description = isset($acf['hero']['description']) ? $acf['hero']['description'] : '';
$image = isset($acf['hero']['image']) ? $acf['hero']['image'] : [];
$buttons = isset($acf['hero']['buttons']) ? $acf['hero']['buttons'] : [];
@endphp
<section class="component-section mb-12 md:mb-16">
  <div class="component-inner-section">
    <div class="relative flex flex-col items-center xl:grid grid-cols-12 gap-10 text-white bg-brand p-4 sm:p-12 rounded-2xl overflow-hidden">
    <div class="absolute inset-0 z-0" style="background: url(@asset('/images/header-bg.png')) center center; background-size: cover;"></div>
      <div class="col-span-7 xl:col-span-6 z-10 order-2 xl:order-1 text-center xl:text-left">
        <h1 class="text-4xl lg:text-5xl mb-5">{!! $title !!}</h1>
        <div class="text-lg font-medium">{!! $description !!}</div>
        @if ($buttons)
          @php
            $data = [
              'justify' => 'justify-start',
            ];
          @endphp
          @include('components.action-buttons', $data)
        @endif
      </div>
      <div class="col-span-5 lg:col-span-6 z-10 order-1 xl:order-2">
        @if ($image)
          <div>
            <img class="w-full mx-auto max-w-xs xl:max-w-full"
              src="{{ $image['sizes']['medium_large'] }}"
              alt="{{ $image['alt'] }}" />
          </div>
        @endif
      </div>
    </div>
  </div>
</section>

@include('partials.content-release-note-latest')

@include('partials.content-front-page-products')

