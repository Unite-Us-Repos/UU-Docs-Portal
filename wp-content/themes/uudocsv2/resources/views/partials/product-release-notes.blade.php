
@php
$term = get_queried_object();
$term_link = get_site_url() . '/' . $term->taxonomy . '/' . $term->slug . '/';
@endphp
@if ($related_release_notes)
<section class="release-notes component-section">
    <div class="component-inner-section">
      <div class="flex flex-col gap-6 sm:flex-row sm:justify-between sm:items-center mb-6">
        <div>
          <h2 id="related-release-notes}" class="flex flex-row mb-0 xl:-ml-10 gap-4 group">
          <a href="{{ $term_link }}#related-release-notes" class="copy-anchor flex items-center opacity-0 border-0 group-hover:opacity-100" aria-label="Anchor"><div x-data="" x-ripple="" class="button-ripple group-hover:opacity-100 w-6 h-6 text-slate-400 ring-1 ring-slate-900/5 rounded-md shadow-sm flex items-center justify-center hover:ring-slate-900/10 hover:shadow hover:text-action"><svg class="group-hover:opacity-100" width="11" height="11" viewBox="0 0 11 11" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6.06267 4.58604C5.28162 3.80499 4.01529 3.80499 3.23423 4.58604L1.23423 6.58605C0.453175 7.3671 0.453175 8.63344 1.23423 9.41449C2.01528 10.1955 3.28161 10.1955 4.06266 9.41449L4.61345 8.86371M4.23424 6.41448C5.01529 7.19553 6.28162 7.19553 7.06267 6.41448L9.06268 4.41447C9.84373 3.63342 9.84373 2.36708 9.06268 1.58603C8.28163 0.804981 7.0153 0.804981 6.23424 1.58603L5.68444 2.13584" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"></path></svg></div></a>
            Related Release Notes
        </h2>
        </div>
        <div>
          <a href="/release-notes/?_sft_product={{ get_queried_object()->slug }}" class="no-underline font-semibold inline-flex gap-3 items-center">
            <span>View All Updates</span>
            <span>
              <svg width="13" height="11" viewBox="0 0 13 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M7.875 1.39209L12 5.51709M12 5.51709L7.875 9.64209M12 5.51709L1 5.51709" stroke="#216cff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </span>
          </a>
        </div>
      </div>

      <div class="grid gap-8 lg:grid-cols-3">
        @foreach ($related_release_notes as $index => $post)
          <div class="relative flex flex-col text-left rounded-lg shadow-lg overflow-hidden group">
            <div class="absolute w-full top-0 p-2 bg-action rounded-t-lg z-20"></div>
            <div class="absolute inset-0 related-gradient opacity-0 group-hover:opacity-100 z-10"></div>

            <div class="flex-1 bg-white flex flex-col justify-between">
              <div class="flex-1 p-8 pt-10 z-20">
                <div class="text-sm uppercase font-medium text-action mb-4">
                    Release Note
                </div>

                <h3 class="mb-4">
                  @if ($post['permalink'])
                    <a
                      class="no-underline font-bold text-xl text-brand group-hover:text-action"
                      href="{{ $post['permalink'] }}"
                      >
                  @endif
                  {!! $post['post_title'] !!}
                  @if ($post['permalink'])
                    </a>
                  @endif
                </h3>

                <p class="text-xs font-medium text-action mb-4">
                  @if (get_field('tbd', $post['ID']))
                    <span class="dt-published text-sm">
                      Release date: TBD
                    </span>
                  @else
                    Release date: {{ $post['date'] }}
                  @endif
                </p>
                @isset ($post['excerpt'])
                  <div>{!! $post['excerpt'] !!}</div>
                @endisset

                <div class="relative z-30 mt-4">@include('partials.content-release-note-pills')</div>

                @if ($post['permalink'])
                  <div class="absolute inset-0 rounded-t-lg z-20">
                    <a
                      class="no-underline absolute inset-0 font-bold text-xl text-brand"
                      href="{{ $post['permalink'] }}"
                      >
                      <span class="hidden not-sr-only" >{!! $post['post_title'] !!}</span>
                    </a>
                  </div>
                @endif
              </div>
            </div>
          </div>
        @endforeach
      </div>

    </div>
    </div>
</section>
@endif


