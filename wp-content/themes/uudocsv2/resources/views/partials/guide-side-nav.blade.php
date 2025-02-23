@php
$active_section = '';
$terms = get_the_terms($post->ID, 'guide_section');
if ($terms) {
  foreach($terms as $term) {
    $active_section = $term->term_id;
  }
}
@endphp
<nav class="flex flex-1 flex-col">
  <ul role="list" class="list-none flex flex-1 flex-col gap-y-2">
    <li>
      <ul x-data="{ selected: {{ $active_section }} }" role="list" class="list-none mt-2">
        <li class="mb-1 @if (is_page('release-notes') OR (('release_note' == get_post_type()) && is_singular('release_note'))) bg-light rounded-md @else @endif">
          <a href="/release-notes/" class="hover:bg-pale-blue no-underline items-center group flex gap-x-3 rounded-md p-2 text-sm font-semibold" x-state:on="Current" x-state:off="Default">
            <span class="text-action flex h-8 w-8 shrink-0 items-center justify-center rounded-md border text-sm font-medium bg-white">
              {{ svg('acf.document-text')->class('w-5 h-5') }}
            </span>
            <span class="text-brand font-medium">Release Notes</span>
          </a>
        </li>
        @foreach ($guides_side_navigation as $nav)
          @php
            $filter_only = isset($nav['nav_item']['filter_only']) ? $nav['nav_item']['filter_only'] : false;
          @endphp
          @if ($filter_only)
            @continue
          @endif
          <li class="mb-1 @if ($nav['nav_item']['is_active']) bg-light pb-4 rounded-md @else @endif">

            <a href="{{ $nav['nav_item']['link'] }}" class="@if ($nav['nav_item']['is_active_guide']) bg-light rounded-md @endif hover:bg-pale-blue no-underline items-center group flex gap-x-3 rounded-md p-2 text-sm font-semibold" x-state:on="Current" x-state:off="Default">
              <span class="flex text-action h-8 w-8 shrink-0 items-center justify-center rounded-md border text-sm font-medium bg-white">
                @isset ($nav['nav_item']['icon'])
                  {{ svg('acf.'.$nav['nav_item']['icon'])->class('w-5 h-5') }}
                @endisset
              </span>
              <span class="text-brand font-medium">{{ $nav['nav_item']['name'] }}</span>
            </a>

            @foreach ($nav['sections'] as $index => $section)
              @if ($section['posts'])


                <ul class="list-none px-6">
                  <li class="pt-2">
                    <button @click="selected !== {{ $section['term_id'] }} ? selected = {{ $section['term_id'] }} : selected = null"
                      class="w-full flex justify-between items-center">
                      <span class="text-brand text-left text-sm font-bold block">{{ $section['title'] }}</span>
                      <div>
                        <span class="text-lg transition-all block transition-none "
                            :class="selected === {{ $section['term_id'] }} ? 'rotate-180' : ''">
                            <svg width="16" height="5" viewBox="0 0 16 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                             <path d="M1 1L8 8L15 1" stroke="#216cff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </span>
                      </div>
                    </button>
                    <div x-cloak x-show="selected === {{ $section['term_id'] }}" class="text-sm text-black/50 p-3"
                      x-transition:enter="transition ease-out duration-100"
                      x-transition:enter-start="transform opacity-0">
                      <ul class="list-none">
                        @foreach ($section['posts'] as $post)
                          <li class="pl-4 py-1 @if ($post['is_active'] == '1') border-l-2 border-action @else border-l border-pale-blue-dark @endif">
                            <a href="{{ $post['permalink'] }}" class="@if ($post['is_active'] == '1') text-action font-bold @else text-brand font-normal @endif inline-block text-sm no-underline">
                              {{ $post['post_title'] }}
                            </a>
                        </li>
                        @endforeach
                      </ul>
                    </div>
                  </li>
                </ul>
              @endif
            @endforeach
          </li>
        @endforeach
      </ul>
    </li>
  </ul>
  <div class="absolute top-0 bottom-1/2 h-full w-[4000px] -mb-[1px] bg-white z-20" style="margin-left:-4020px"></div>
</nav>
