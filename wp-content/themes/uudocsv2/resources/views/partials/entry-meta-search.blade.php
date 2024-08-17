@php
if (!isset($linkable)) {
  $linkable = true;
}
@endphp
<div class="flex text-lg">
  @if ($linkable)
    <a href="/{{ $catSlug }}/">
  @endif
    <span class="text-sm font-medium  mr-6">
      <span class="inline-block bg-action text-white font-medium rounded-full px-4 py-1">
        {{ $type }}
      </span>
    </span>
  @if ($linkable)
    </a>
  @endif
  <time class="" datetime="{{ get_post_time('c', true) }}">
    {{ get_the_date() }}
  </time>
</div>
