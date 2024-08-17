<section class="component-section mb-12 sm:mb-16">
  <div class="component-inner-section relative">
    <div class="relative flex flex-col items-center sm:grid grid-cols-12 gap-10 text-white bg-brand p-4 sm:p-12 rounded-2xl overflow-hidden">
      <div class="absolute inset-0 z-0" style="background: url(@asset('/images/header-bg.png')) center center; background-size: cover;">
      </div>
      <div class="col-span-8 text-center order-2 sm:text-left sm:order-1 z-10">
        <h1 class="text-3xl sm:text-4xl md:text-5xl mb-5">{!! $title !!}</h1>
        <div class="text-lg font-medium max-w-lg">{!! term_description() !!}</div>
      </div>
      <div class="col-span-4 order-1 sm:order-3 z-10">
        @isset ($product['image'])
          <div>
            <img class="mx-auto w-full h-auto max-w-[194px] xl:max-w-[225px]"
              src="{{ $product['image']['sizes']['medium_large'] }}"
              alt="" />
          </div>
        @endif
      </div>
    </div>
  </div>
</section>

@php
$extra_content = false;
@endphp
@if ('mini-cards' == $extra_content)
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-10 gap-3">
              @foreach ($mini_cards as $card)
                <div class="relative border border-blue-200 rounded-xl p-6 group">
                  <div class="relative z-10">
                  <h2 class="font-extrabold text-3xl text-action mb-0 leading-10">{!! $card['title'] !!}</h2>
                  <div>{!! $card['description'] !!}</div>
                  </div>
                  <div class="absolute inset-0 mini-card-grad z-0 rounded-xl opacity-0 group-hover:opacity-100">
                  </div>
                </div>
              @endforeach
            </div>
          @endif

@include('partials.product-guides')

@include('partials.product-release-notes')
