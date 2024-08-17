@php
  $post_id = '';
  if (is_singular('release_note')) {
    $post_id = get_the_ID();
  } else {
    if (is_array($post)) {
      if (isset($post['ID'])) {
        $post_id = $post['ID'];
      }
    }
  }

  $release_note_taxonomies = [];
  $custom_taxonomies = ['product', 'feature', 'user'];

  if ($post_id) {
    foreach ($custom_taxonomies as $taxonomy) {
        $release_note_taxonomies[] = get_the_terms($post_id, $taxonomy);
    }
  }
@endphp

@if ($release_note_taxonomies)
  <div class="flex flex-wrap gap-2">
    @foreach ($release_note_taxonomies as $index => $taxonomies)
      @if ($taxonomies)
        @foreach ($taxonomies as $taxonomy)
          @if ($taxonomy)
          <a class="flex gap-2 px-4 py-1 justify-center items-center no-underline text-brand hover:shadow-inner border-2 border-pale-blue-dark rounded-2xl" href="/release-notes/?_sft_{{ $taxonomy->taxonomy }}={{ $taxonomy->slug }}">
            <span class="rounded-full shrink-0 w-2 h-2 bg-marketing-{{ $taxonomy->taxonomy }}"></span>
            <span class="text-sm bg-transparent font-regular pill-span">
              {!! $taxonomy->name !!}
            </span>
          </a>
          @endif
        @endforeach
      @endif
    @endforeach
  </div>
@endif
