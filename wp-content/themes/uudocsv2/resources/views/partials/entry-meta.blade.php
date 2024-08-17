<div class="flex flex-wrap gap-6">
  @if (isset($acf['tbd']) && $acf['tbd'])
    <span class="dt-published text-sm">
      Release Date: TBD
    </span>
    @else
    <time class="dt-published text-sm" datetime="{{ get_post_time('c', true) }}">
      Release Date: {{ the_date() }}
    </time>
    @if (get_the_date() !== get_the_modified_date())
      <time class="dt-updated text-sm" datetime="{{ get_post_time('c', true) }}">
        Updated: {{ get_the_modified_date() }}
      </time>
    @endif
  @endif
</div>

