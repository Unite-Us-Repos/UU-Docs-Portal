<style>
.leading-6 {
  line-height: 1.5rem;
}
</style>
@foreach ($guides_side_navigation as $index => $nav)
  @php
    $filter_only = isset($nav['nav_item']['filter_only']) ? $nav['nav_item']['filter_only'] : false;
  @endphp
  @if ($filter_only)
    @php unset($guides_side_navigation[$index]); @endphp
  @endif
@endforeach
@php
$productGrid = get_field('product_grid');
$grid_title = isset($productGrid['title']) ? $productGrid['title'] : '';
$grid_description = isset($productGrid['description']) ? $productGrid['description'] : '';
@endphp
<section class="component-section mb-6">
  <div class="component-inner-section">
    <div class="mb-6">
      @if ($grid_title)
        <h2 class="mb-6">{!! $grid_title !!}</h2>
      @endif
      @if ($grid_description)
        <div class="text-lg">
          <div class="max-w-5xl">
            {!! $grid_description !!}
          </div>
        </div>
      @endif
    </div>
  </div>


  <div class="component-inner-section">
    <div class="flex flex-col sm:flex-wrap justify-center sm:flex-row -ml-3 -mr-3">

    @foreach ($guides_side_navigation as $nav)
      @php
        $filter_only = isset($nav['nav_item']['filter_only']) ? $nav['nav_item']['filter_only'] : false;
      @endphp
      @if ($filter_only)
        @continue
      @endif

      <div class="sm:basis-6/12  @if (count($guides_side_navigation) > 3) xl:basis-1/4 @else xl:basis-2/6 @endif">
        <div x-data="{ expanded: false }" class="relative m-4">
            <div class="shadow-2xl relative flex items-end rounded-lg overflow-hidden group service-card-squared aspect-square product-box-gradient">
              <div class="absolute inset-0 opacity-10 flex items-end border">
                <div class="h-1/3 w-full">
                  <img class="object-fit w-full h-full" src="@asset('/images/wave-pattern.png')" alt="" />
                </div>
              </div>

              @isset ($nav['nav_item']['image'])
                <div class="absolute inset-0 -mb-10 p-8 sm:p-16">
                  <img class="mx-auto relative -top-4"
                    src="{{ $nav['nav_item']['image']['sizes']['medium_large'] }}"
                    alt="" />
                </div>
              @endisset

              <div class="relative w-full p-7 pb-0">
                <div class="absolute inset-0 border-b-[15px] border-action-dark transition ease-in-out delay-250 group-hover:opacity-0 group-hover:z-0"></div>
                  <div class="absolute inset-0 bg-gradient-service group-hover:opacity-100"></div>
                  <div class="relative text-white pb-4">
                    <a class="no-underline text-white" href="{{ $nav['nav_item']['link'] }}">
                      <h3 class="mb-4 text-2xl font-bold leading-6 tracking-tight">{{ $nav['nav_item']['name'] }}</h3>
                    </a>
                    @if ($nav['nav_item']['description'])
                      <div x-show="expanded" x-collapse.duration.400ms class="relative text-sm mb-4 w-full">
                        {{ $nav['nav_item']['description'] }}
                      </div>
                    @endif
                  </div>
                </div>
              </div>
          <a @mouseover="expanded = ! expanded" @mouseout="expanded = false" class="absolute inset-0 z-40 no-underline block p-14" href="{{ $nav['nav_item']['link'] }}" alt=""><span class="sr-only">{{ $nav['nav_item']['name'] }}</span></a>
        </div>
      </div>
    @endforeach
    </div>
  </div>
</section>

