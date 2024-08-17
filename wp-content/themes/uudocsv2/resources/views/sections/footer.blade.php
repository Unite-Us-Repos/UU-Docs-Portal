</div><!-- close wrap -->
<div class="w-full lg:pl-72 relative mt-10">
@if (!is_singular('guide') AND !is_singular('release_note'))
@php
$footerCta = get_field('footer_cta', 'option');
$title = isset($footerCta['title']) ? $footerCta['title'] : '';
$subtitle = isset($footerCta['title']) ? $footerCta['subtitle'] : '';
$description = isset($footerCta['description']) ? $footerCta['description'] : '';
$image = isset($footerCta['image']) ? $footerCta['image'] : [];
$buttons = isset($footerCta['buttons']) ? $footerCta['buttons'] : [];
@endphp
<div class="absolute inset-0 w-full h-full -mb-[1px] bg-blue-900 z-10"></div>

  <section class="relative z-20">
    <div class="component-inner-section">
      <div class="absolute top-0 bottom-1/2 left-0 w-full -mb-[1px] bg-white"></div>

        <div class="component-inner-section relative" style="padding: 0 1.25rem;">
          <div class="bg-light w-full rounded-2xl p-9 lg:p-14 flex flex-col gap-6 lg:relative lg:flex-none lg:grid lg:grid-cols-12 lg:gap-14">

          <div class="col-span-6 order-2 font-regular flex flex-col justify-center text-2xl lg:order-1 lg:mb-0">
            @if ($subtitle)
              <div class="text-center lg:text-left subtitle n-case mb-3">
                {!! $subtitle !!}
              </div>
            @endif
            @if ($title)
              <h2 class="text-center lg:text-left mb-0 font-bold text-4xl">{!! $title !!}</h2>
            @endif
            @if ($buttons)
              @php
                $data = [
                  'justify' => 'justify-start',
                ];
              @endphp
              @include('components.action-buttons', $data)
            @endif
          </div>

        <div class="col-span-6 relative flex flex-col justify-center lg:order-2 ">
          @if ($image)
            <img class="w-full mx-auto max-w-xs xl:max-w-full"
              src="{{ $image['sizes']['medium_large'] }}"
              alt="{{ $image['alt'] }}" />
          @endif
        </div>
      </div>
    </div>
  </section>
@endif

<footer class="relative footer-section z-20" aria-labelledby="footer-heading">
  <div class="absolute inset-0 border border-blue-900 w-full h-full -mb-[1px] bg-blue-900 z-10"></div>
    <div class="component-inner-section bg-blue-900 py-14">
      <h2 id="footer-heading" class="sr-only">Footer</h2>
      <div class="component-inner-section">
        <div class="relative flex flex-col gap-10 items-center z-20">
            @if (has_nav_menu('footer_navigation'))
              {!!
                wp_nav_menu([
                  'theme_location'  => 'footer_navigation',
                  'menu_class'      => 'flex flex-wrap list-none justify-center',
                  'echo'            => false,
                  'link_class'      => 'text-white inline-block p-2 sm:py-0 px-5 hover:text-white'
                ])
              !!}
            @endif

            <div class="flex space-x-6">

              @if ($socialMediaIcons)
                @foreach ($socialMediaIcons as $social)
                  <a href="{{ $social['url'] }}" target="_blank" class="text-white hover:text-blue-400">
                    <span class="sr-only">{{ $social['label'] }}</span>
                    {{ svg('social.'.$social['icon'])->class('w-5 h-5') }}
                  </a>
                @endforeach
              @endif

          </div>

          <p class="text-base text-center text-white m-0">&copy; {{ $currentYear }} Unite Us. All rights reserved.</p>

        </div>
      </div>
    </div>
  </div>
</footer>
<script>
  jQuery().ready(function($) {
    $('#wpadminbar ul').addClass('list-none');
  });
  </script>
