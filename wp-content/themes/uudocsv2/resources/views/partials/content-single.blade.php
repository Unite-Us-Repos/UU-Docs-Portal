<style>
  .button-ripple {
    /* We need this to position
    span inside button */
    position: relative;
    overflow: hidden;
  }

  :root {
    --ripple-color: #C7D8E8;
  }

  .copy-anchor {
    cursor: copy;
  }
</style>
@if ($post->post_type == 'release_note')
  @php
    $prev = get_previous_post_link('%link');
    $next = get_next_post_link('%link');

    $prev2 = get_previous_post_link('%link', '<span class="sr-only">%title</span>');
    $next2 = get_next_post_link('%link', '<span class="sr-only">%title</span>');

    $prev2 = str_replace('href', 'class="absolute inset-0 z-20" href', $prev2);
    $next2 = str_replace('href', 'class="absolute inset-0 z-20" href', $next2);

    $prev = str_replace('href', 'class="no-underline font-semibold text-lg text-brand group-hover:text-action"
    href', $prev);
    $next = str_replace('href', 'class="no-underline font-semibold text-lg text-brand group-hover:text-action"
    href', $next);
  @endphp
@endif
<article @php (post_class('h-entry section-content')) @endphp>
  <header class="component-inner-section">
    <div class="border-b-2 border-pale-blue pb-10 mb-10">
      <div class="items-center flex flex-col md:grid md:grid-cols-12 md:gap-12">
        <div class="col-span-9">
          <div class="flex justify-between items-center uppercase text-base font-semibold mb-6">
            @if (is_singular('guide'))
              @foreach ($associated_product as $product)
                <a class="no-underline" href="/{{ $product->taxonomy }}/{{ $product->slug }}/">{{ $product->name }}</a>
              @endforeach
            @endif

            @if (is_singular('release_note'))
              <span class="text-action">Release Notes</span>
            @endif

            @foreach ($associated_product as $product)
              @php
                $product_image = isset($product->acf['image']['sizes']['medium_large']) ?
                $product->acf['image']['sizes']['medium_large'] : '';
                if (is_singular('release_note')) {
                $product_image = 'https://docportaldev.wpengine.com/wp-content/uploads/2023/04/Release-Notes.png';
                }
              @endphp
              @isset ($product->acf['image'])
                <div class="sm:hidden">
                  <img class="mx-auto max-w-[76px]" src="{{ $product_image }}" alt="" />
                </div>
              @endisset
              @break
            @endforeach
          </div>
          <h1 class="p-name text-4xl mb-6">
            {!! $title !!}
          </h1>
          @include('partials.entry-meta')
        </div>

        <div class="col-span-3">
          @foreach ($associated_product as $product)
            @php
              $product_image = isset($product->acf['image']['sizes']['medium_large']) ?
              $product->acf['image']['sizes']['medium_large'] : '';
              if (is_singular('release_note')) {
              $product_image = 'https://docportaldev.wpengine.com/wp-content/uploads/2023/04/Release-Notes.png';
              }
            @endphp
            @isset ($product->acf['image'])
              <div class="hidden md:block">
                <img class="mx-auto max-w-[124px]" src="{{ $product_image }}" alt="" />
              </div>
            @endisset
            @break
          @endforeach
        </div>
      </div>
      @if ('release_note' == get_post_type())
        <div class="mt-6">@include('partials.content-release-note-pills')</div>
      @endif
    </div>
  </header>
  <div class="component-inner-section">
    @include('partials.component-alert')
    <div class="flex flex-col md:grid md:grid-cols-12 md:gap-12">
      <div class="col-span-3 lg:col-span-3 md:order-2">
        <div class="md:hidden text-sm font-bold mb-10 flex justify-center items-center">

          <div x-data="Components.menu({ open: false })" x-init="init()"
            @keydown.escape.stop="open = false; focusButton()" @click.away="onClickAway($event)"
            class="relative inline-block text-left w-full">
            <div>
              <button type="button"
                class="inline-flex w-full justify-between items-center gap-x-1.5 rounded-md bg-white px-6 py-4 text-base font-semibold text-brand hover:bg-light hover:bg-opacity-30 shadow-md ring-1 ring-inset ring-light ring-opacity-50"
                id="menu-button" x-ref="button" @click="onButtonClick()" @keyup.space.prevent="onButtonEnter()"
                @keydown.enter.prevent="onButtonEnter()" aria-expanded="true" aria-haspopup="true"
                x-bind:aria-expanded="open.toString()" @keydown.arrow-up.prevent="onArrowUp()"
                @keydown.arrow-down.prevent="onArrowDown()">
                Jump To
                <svg width="8" height="15" viewBox="0 0 8 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M4 0.353027C4.26522 0.353027 4.51957 0.458384 4.70711 0.645921L7.70711 3.64592C8.09763 4.03645 8.09763 4.66961 7.70711 5.06013C7.31658 5.45066 6.68342 5.45066 6.29289 5.06013L4 2.76724L1.70711 5.06013C1.31658 5.45066 0.683417 5.45066 0.292893 5.06013C-0.0976311 4.66961 -0.097631 4.03644 0.292893 3.64592L3.29289 0.64592C3.48043 0.458384 3.73478 0.353027 4 0.353027ZM0.292893 9.64592C0.683417 9.2554 1.31658 9.2554 1.70711 9.64592L4 11.9388L6.29289 9.64592C6.68342 9.2554 7.31658 9.2554 7.70711 9.64592C8.09763 10.0364 8.09763 10.6696 7.70711 11.0601L4.70711 14.0601C4.31658 14.4507 3.68342 14.4507 3.29289 14.0601L0.292893 11.0601C-0.0976311 10.6696 -0.0976311 10.0364 0.292893 9.64592Z"
                    fill="#216cff" />
                </svg>
              </button>
            </div>

            <div x-show="open" x-transition:enter="transition ease-out duration-100"
              x-transition:enter-start="transform opacity-0 scale-95"
              x-transition:enter-end="transform opacity-100 scale-100"
              x-transition:leave="transition ease-in duration-75"
              x-transition:leave-start="transform opacity-100 scale-100"
              x-transition:leave-end="transform opacity-0 scale-95"
              class="absolute left-0 right-0 w-full z-10 mt-2 w-56 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
              x-ref="menu-items" x-description="Dropdown menu, show/hide based on menu state."
              x-bind:aria-activedescendant="activeDescendant" role="menu" aria-orientation="vertical"
              aria-labelledby="menu-button" tabindex="-1" @keydown.arrow-up.prevent="onArrowUp()"
              @keydown.arrow-down.prevent="onArrowDown()" @keydown.tab="open = false"
              @keydown.enter.prevent="open = false; focusButton()" @keyup.space.prevent="open = false; focusButton()">
              <div id="js-toc-navigation" class="py-4" role="none"></div>
            </div>

          </div>

        </div>
        <div class="sticky top-10 hidden md:block">
          <div class="text-sm font-bold mb-4">Jump To:</div>
          <div id="js-toc" class="js-toc relative"></div>
        </div>
      </div>
      <div class="col-span-9 lg:col-span-9 sm:order-1">
        <div class="e-content js-toc-content mb-10">
          @php (the_content()) @endphp
        </div>

        @if ($post->post_type == 'release_note')
          <div class="flex flex-col mt-16 gap-5 md:grid md:grid-cols-2">
            @if ($prev)
            <div
              class="@if (!$next) col-span-12 @endif relative flex flex-col text-left rounded-lg shadow-lg overflow-hidden group order-2 md:order-1">
              <div class="absolute w-full top-0 p-2 bg-action rounded-t-lg z-20"></div>
              <div class="absolute inset-0 related-gradient opacity-0 group-hover:opacity-100 z-10"></div>

              <div class="flex-1 bg-white flex flex-col justify-between">
                <div class="flex-1 p-8 pt-10 z-20">
                  <div class="flex justify-between text-sm uppercase font-medium text-action mb-4">
                    <span class="text-gray-500 group-hover:text-action order-2">Previous</span>
                    <span class="order-1 w-5 h-5 text-gray-500 group-hover:text-action">
                      <svg width="23" height="19" viewBox="0 0 23 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                          d="M9.1765 17.5396L1.35297 9.71611M1.35297 9.71611L9.1765 1.89258M1.35297 9.71611L21.4706 9.71611"
                          stroke="currentColor" stroke-width="2.23529" stroke-linecap="round" stroke-linejoin="round" />
                      </svg>
                    </span>
                  </div>
                  {!! $prev !!}
                </div>
              </div>
              {!! $prev2 !!}
            </div>
            @endif

            @if ($next)
            <div
              class="@if (!$prev) col-span-12 @endif  relative flex flex-col text-left rounded-lg shadow-lg overflow-hidden group order-1 md:order-2">
              <div class="absolute w-full top-0 p-2 bg-action rounded-t-lg z-20"></div>
              <div class="absolute inset-0 related-gradient opacity-0 group-hover:opacity-100 z-10"></div>

              <div class="flex-1 bg-white flex flex-col justify-between">
                <div class="flex-1 p-8 pt-10 z-20 items">
                  <div class="flex justify-between text-sm uppercase font-medium text-action mb-4">
                    <span class="text-gray-500 group-hover:text-action">Next</span>
                    <span class="w-5 h-5 text-gray-500 group-hover:text-action">
                      <svg width="23" height="19" viewBox="0 0 23 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                          d="M13.8235 1.89258L21.6471 9.71611M21.6471 9.71611L13.8235 17.5396M21.6471 9.71611L1.52942 9.71611"
                          stroke="currentColor" stroke-width="2.23529" stroke-linecap="round" stroke-linejoin="round" />
                      </svg>
                    </span>
                  </div>
                  {!! $next !!}
                </div>
              </div>
              {!! $next2 !!}
            </div>
            @endif
          </div>
        @endif

      </div>
    </div>
  </div>
</article>


<script src="https://cdnjs.cloudflare.com/ajax/libs/tocbot/4.18.2/tocbot.min.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    setTimeout(function () {
      tocbot.init({
        // Where to render the table of contents.
        tocSelector: '.js-toc',
        // Where to grab the headings to build the table of contents.
        contentSelector: '.js-toc-content',
        // Which headings to grab inside of the contentSelector element.
        headingSelector: 'h2',
        listClass: 'list-none toc-list',
        scrollSmooth: false,
        headingsOffset: 26,
        scrollEndCallback: function (e) {
          console.log(e);
        },
      });
    }, 100);
  }, false);


  jQuery().ready(function ($) {

    function generateLevel2Anchors() {
      const mainHeadings = document.querySelectorAll('h2');
      // forEach is available on the elements
      mainHeadings.forEach(function (el) {
        // add class to heading
        el.classList.add('group');
        el.classList.add('xl:-ml-10');
        var id = el.getAttribute("id");
        var anchor = '<a href="<?php the_permalink(); ?>#' + id +
          '" class="copy-anchor flex items-center opacity-0 border-0 group-hover:opacity-100" aria-label="Anchor"><div x-data x-ripple class="button-ripple group-hover:opacity-100 w-6 h-6 text-slate-400 ring-1 ring-slate-900/5 rounded-md shadow-sm flex items-center justify-center hover:ring-slate-900/10 hover:shadow hover:text-action"><svg class="group-hover:opacity-100" width="11" height="11" viewBox="0 0 11 11" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6.06267 4.58604C5.28162 3.80499 4.01529 3.80499 3.23423 4.58604L1.23423 6.58605C0.453175 7.3671 0.453175 8.63344 1.23423 9.41449C2.01528 10.1955 3.28161 10.1955 4.06266 9.41449L4.61345 8.86371M4.23424 6.41448C5.01529 7.19553 6.28162 7.19553 7.06267 6.41448L9.06268 4.41447C9.84373 3.63342 9.84373 2.36708 9.06268 1.58603C8.28163 0.804981 7.0153 0.804981 6.23424 1.58603L5.68444 2.13584" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/></svg></div></a>';
        el.insertAdjacentHTML('afterbegin', anchor);
        // Do something with el
        // Create a new element

        var newNode = document.createElement('div');
        newNode.setAttribute("class", "h2-divider");
        // Get the reference node
        var referenceNode = document.getElementById(id);

        // Insert the new node before the reference node
        referenceNode.parentNode.insertBefore(newNode, referenceNode);
      });
    }

    function generateLowerLevelAnchors() {
      const headings = document.querySelectorAll('h3, h4, h5, h6');
      // forEach is available on the elements
      headings.forEach(function (el) {
        // add class to heading
        el.classList.add('group');
        el.classList.add('xl:-ml-10');
        var id = el.getAttribute("id");
        var anchor = '<a href="<?php the_permalink(); ?>#' + id +
          '" class="copy-anchor flex items-center opacity-0 border-0 group-hover:opacity-100" aria-label="Anchor"><div x-data x-ripple class="button-ripple group-hover:opacity-100 w-6 h-6 text-slate-400 ring-1 ring-slate-900/5 rounded-md shadow-sm flex items-center justify-center hover:ring-slate-900/10 hover:shadow hover:text-action"><svg class="group-hover:opacity-100" width="11" height="11" viewBox="0 0 11 11" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6.06267 4.58604C5.28162 3.80499 4.01529 3.80499 3.23423 4.58604L1.23423 6.58605C0.453175 7.3671 0.453175 8.63344 1.23423 9.41449C2.01528 10.1955 3.28161 10.1955 4.06266 9.41449L4.61345 8.86371M4.23424 6.41448C5.01529 7.19553 6.28162 7.19553 7.06267 6.41448L9.06268 4.41447C9.84373 3.63342 9.84373 2.36708 9.06268 1.58603C8.28163 0.804981 7.0153 0.804981 6.23424 1.58603L5.68444 2.13584" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/></svg></div></a>';
        el.insertAdjacentHTML('afterbegin', anchor);
      });
    }

    setTimeout(() => {
      generateLevel2Anchors();
    }, 200);

    setTimeout(() => {
      generateLowerLevelAnchors();
    }, 300);

    setTimeout(function () {
      // Populate dropdown with menu items
      $(".js-toc-content h2").each(function ($index) {
        var el = $(this);
        var val = el.attr("id");
        var text = el.text();

        var $link = '<a href="#' + val +
          '" class="mobile-nav-jump block no-underline px-6 py-2" :class="{ \'text-base font-semibold\': activeIndex === ' +
          $index + ', \'text-base font-semibold text-gray-700\': !(activeIndex === ' + $index +
          ') }" role="menuitem" tabindex="-1" id="drop-menu-item-' + $index +
          '" @mouseenter="onMouseEnter($event)" @mousemove="onMouseMove($event, ' + $index +
          ')" @mouseleave="onMouseLeave($event)" @click="open = false; focusButton()">' + text + '</a>';

        $($link).appendTo("#js-toc-navigation");
      });
    }, 500);

    $("#js-toc-navigation select").change(function () {
      window.location = $(this).find("option:selected").val();
    });

    const onScrollStop = callback => {
      let isScrolling;
      window.addEventListener(
        'scroll',
        e => {
          clearTimeout(isScrolling);
          isScrolling = setTimeout(() => {
            callback();
          }, 150);
        },
        false
      );
    };

    $('body').on('click', '.copy-anchor', function () {
      var link = $(this).attr('href');
      navigator.clipboard.writeText(link);
      return false;
    });

    function scrollToAnchor(aid) {
      const destination = $(aid);
      $('html,body').animate({
        scrollTop: destination.offset().top - 78
      }, 'slow');
    }

    $('body').on('click', '.mobile-nav-jump', function () {
      var anchor = $(this).attr('href');
      scrollToAnchor(anchor);
      return false;
    });
  });
</script>
<script>
  jQuery().ready(function ($) {
    $(window).on("load", function () {
      var anchor = window.location.hash.replace('#', '');
      if (anchor) {
        setTimeout(function () {
          scrollToAnchor(anchor);
        }, 200);
      }
    });

    function scrollToAnchor(selector) {
      const destination = $("[id='" + selector + "']");
      $('html,body').animate({
        scrollTop: destination.offset().top
      }, 'slow');
    }
  });
</script>

