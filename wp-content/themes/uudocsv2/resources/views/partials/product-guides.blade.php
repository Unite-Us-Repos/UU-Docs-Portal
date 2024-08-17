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
@php
$term = get_queried_object();
$term_link = get_site_url() . '/' . $term->taxonomy . '/' . $term->slug . '/';
@endphp
<section class="component-section">
  <div class="component-inner-section">
    @foreach ($guides_by_sections as $guide_index => $section)
      @if ($section['posts'])
        <h2 id="{{ $section['slug'] }}" class="flex flex-row mb-3 xl:-ml-10 gap-4 group">
          <a href="{{ $term_link }}#{{ $section['slug'] }}" class="copy-anchor flex items-center opacity-0 border-0 group-hover:opacity-100" aria-label="Anchor"><div x-data="" x-ripple="" class="button-ripple group-hover:opacity-100 w-6 h-6 text-slate-400 ring-1 ring-slate-900/5 rounded-md shadow-sm flex items-center justify-center hover:ring-slate-900/10 hover:shadow hover:text-action"><svg class="group-hover:opacity-100" width="11" height="11" viewBox="0 0 11 11" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6.06267 4.58604C5.28162 3.80499 4.01529 3.80499 3.23423 4.58604L1.23423 6.58605C0.453175 7.3671 0.453175 8.63344 1.23423 9.41449C2.01528 10.1955 3.28161 10.1955 4.06266 9.41449L4.61345 8.86371M4.23424 6.41448C5.01529 7.19553 6.28162 7.19553 7.06267 6.41448L9.06268 4.41447C9.84373 3.63342 9.84373 2.36708 9.06268 1.58603C8.28163 0.804981 7.0153 0.804981 6.23424 1.58603L5.68444 2.13584" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"></path></svg></div></a>
          {{ $section['title'] }}
        </h2>
        {!! wpautop($section['description']) !!}
        <div id="guides{{ $guide_index }}" class="flex flex-col sm:grid grid-cols-2 border border-gray-200 shadow-lg rounded-lg overflow-hidden mt-8 mb-12 sm:mb-16">
          @foreach ($section['posts'] as $index => $post)
            @php
              $hidden_class = '';
              if ($index > 3) {
                $hidden_class = 'hiddenStyle';
              }
            @endphp
            <div class="guide-item {{ $hidden_class }} relative hover:bg-light group @if(($loop->last) && ($loop->odd)) col-span-2 @endif p-7 border-b border-gray-200 sm:border-b @if($loop->odd) sm:border-r @endif @if(($loop->last) OR (($loop->iteration === $loop->count-1) && ($loop->count % 2 == 0))) sm:border-b-0 @endif">
              <div class="w-12 h-12 mb-9 bg-white border border-pale-blue-light shadow-md rounded-md flex justify-center items-center">
                @isset ($post['acf']['icon'])
                  <span class="text-action">
                      {{ svg('acf.'.$post['acf']['icon'])->class('w-5 h-5') }}
                  </span>
                  @else
                  <span class="text-action">
                      {{ svg('acf.spiral-notebook')->class('w-5 h-5') }}
                  </span>
                @endisset
              </div>
              <h3 class="mb-3 text-lg font-medium"><a href="{{ $post['permalink'] }}" class="text-brand no-underline group-hover:text-action group-hover:font-bold">{{ $post['post_title'] }}</a></h3>
              {!! wpautop($post['excerpt']) !!}
              <div class="absolute p-7 flex justify-end inset-0 mini-card-grad z-0 rounded-xl group-hover:opacity-0">
                <img class="w-5 h-5" src="@asset('/images/arrow-diagonal-up.svg')" alt="" />
              </div>
              <div class="absolute p-7 flex justify-end inset-0 mini-card-grad z-0 rounded-xl opacity-0 group-hover:opacity-100">
                <a class="absolute inset-0 z-20" href="{{ $post['permalink'] }}" class="text-brand no-underline"><span class="sr-only">{{ $post['post_title'] }}</span></a>
                <img class="w-5 h-5" src="@asset('/images/arrow-diagonal-up-active.svg')" alt="" />
              </div>
            </div>
          @endforeach
        </div>
        @if (count($section['posts']) > 4)
          <div class="mt-10 mb-10 flex justify-end align-middle">
            <button id="loadMore{{ $guide_index }}" type="button" class="test inline-flex button button-solid">
              <span class="mr-4 inline-block">Load More</span> <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M4 2C4.55228 2 5 2.44772 5 3V5.10125C6.27009 3.80489 8.04052 3 10 3C13.0494 3 15.641 4.94932 16.6014 7.66675C16.7855 8.18747 16.5126 8.75879 15.9918 8.94284C15.4711 9.12689 14.8998 8.85396 14.7157 8.33325C14.0289 6.38991 12.1755 5 10 5C8.36507 5 6.91204 5.78502 5.99935 7H9C9.55228 7 10 7.44772 10 8C10 8.55228 9.55228 9 9 9H4C3.44772 9 3 8.55228 3 8V3C3 2.44772 3.44772 2 4 2ZM4.00817 11.0572C4.52888 10.8731 5.1002 11.146 5.28425 11.6668C5.97112 13.6101 7.82453 15 10 15C11.6349 15 13.088 14.215 14.0006 13L11 13C10.4477 13 10 12.5523 10 12C10 11.4477 10.4477 11 11 11H16C16.2652 11 16.5196 11.1054 16.7071 11.2929C16.8946 11.4804 17 11.7348 17 12V17C17 17.5523 16.5523 18 16 18C15.4477 18 15 17.5523 15 17V14.8987C13.7299 16.1951 11.9595 17 10 17C6.95059 17 4.35905 15.0507 3.39857 12.3332C3.21452 11.8125 3.48745 11.2412 4.00817 11.0572Z" fill="#3B8BCA"></path></svg>
            </button>
          </div>
        @endif
      @endif
    @endforeach
  </div>
</section>
<script>
  jQuery().ready(function ($) {

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
<script type="text/javascript">


  console.clear();
  maxItems = 99;
  loadItems = 2;
  hiddenClass = "hiddenStyle";

  @foreach ($guides_by_sections as $index => $section)
    var work{{ $index }} = document.querySelector("#guides{{ $index }}");
    var items{{ $index }} = Array.from(work{{ $index }}.querySelectorAll(".guide-item"));


    items{{ $index }}.forEach(function (item, index) {
      console.log(item.innerText, index);
      if (index > maxItems - 1) {
        item.classList.add(hiddenClass);
      }
    });

    @if (count($section['posts']) > 4)
    var loadMore{{ $index }} = document.getElementById("loadMore{{ $index }}");

    loadMore{{ $index }}.addEventListener("click", function () {
      [].forEach.call(work{{ $index }}.querySelectorAll("." + hiddenClass), function (
        item,
        index
      ) {
        if (index < loadItems) {
          item.classList.remove(hiddenClass);
        }

        if (work{{ $index }}.querySelectorAll("." + hiddenClass).length === 0) {
          loadMore{{ $index }}.style.display = "none";
        }
      });
    });
    @endif

  @endforeach


</script>
<style>

.hiddenStyle {
  position: absolute;
  overflow: hidden;
  clip: rect(0 0 0 0);
  height: 1px;
  width: 1px;
  margin: -1px;
  padding: 0;
  border: 0;
}

</style>

