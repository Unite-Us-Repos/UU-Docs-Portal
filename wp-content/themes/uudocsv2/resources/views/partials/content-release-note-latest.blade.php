
<section class="component-section">
  <div class="component-inner-section">
  <div class="flex flex-col gap-6 sm:flex-row sm:justify-between sm:items-center mb-6">
        <div>
          <h2 class="mb-0">Latest Releases</h2>
        </div>
        <div>
        <a href="/release-notes/" class="no-underline font-semibold inline-flex gap-3 items-center">
            <span>View All Updates</span>
            <span>
              <svg width="13" height="11" viewBox="0 0 13 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M7.875 1.39209L12 5.51709M12 5.51709L7.875 9.64209M12 5.51709L1 5.51709" stroke="#216cff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </span>
          </a>
        </div>
      </div>
    <div class="flex flex-col rounded-xl bg-light-gradient px-10 py-14">

    @foreach ($latest_release_notes as $note)
@php
$release_note_taxonomies = [];
                $custom_taxonomies = ['product']; // include pills for these taxes only

                foreach ($custom_taxonomies as $taxonomy) {
                    $release_note_taxonomies[] = get_the_terms($note['ID'], $taxonomy);
                }
@endphp
		  <div class="flex md:grid md:grid-cols-12 mb-4">
            <div class="col-span-4">
              <div class="flex flex-col gap-2 md:gap-10 md:grid md:grid-cols-2 h-full">
                  <div class="font-semibold text-action">
                    @if (get_field('tbd', $note['ID']))
                      <span class="dt-published text-sm">
                        Release Date: TBD
                      </span>
                    @else
                      <span class="hidden md:block">{{ get_the_date('F d, Y', $note['ID']) }}</span>
                      <span class="w-24 block md:hidden snot-sr-only">{!! get_the_date('M d,<\b\\r> Y', $note['ID']) !!}</span>
                    @endif
                  </div>

                  <div class="relative flex flex-col items-center h-full mr-10">
                      <div class="@if ($loop->last) hidden @endif absolute top-12 bottom-0 w-[2px] bg-pale-blue-dark top-10" style="margin-left: -2px;"></div>
                        @foreach ($release_note_taxonomies as $index => $taxonomies)

                            <?php if (is_array($taxonomies)) : ?>
                                <?php foreach ($taxonomies as $tax) : ?>
                        <?php if ($tax) : ?>

                        <?php $extras = get_field('product', $tax->taxonomy . '_' . $tax->term_id); ?>
                          <?php $filter_only = isset($extras['filter_only']) ? $extras['filter_only'] : false; ?>
                          <?php if (($tax->taxonomy == 'product')) : ?>
                                            <?php $icon_name = $tax->slug; ?>


                                        <span class="text-action relative z-10 mb-2 flex h-10 w-10 shrink-0 items-center justify-center rounded-full border text-sm font-medium shadow-md bg-white">
                                        <?php if ($extras) : ?>
                                        <?php $icon = $extras['icon']; ?>
                        <?php endif; ?>
                                              @isset ($extras['icon'])
                                                {{ svg('acf.'.$extras['icon'])->class('w-5 h-5') }}
                                              @endisset

                                      </span>
                                      <?php endif; ?>
                                      <?php endif; ?>
                                      <?php break; ?>
                                      <?php endforeach; // just show one icon ?>
                                      <?php endif; ?>
                        @endforeach
                  </div>
                </div>
            </div>
            <div class="col-span-7 pb-10 group relative">
                <h3 class="mb-4 text-2xl font-bold">
                    <a
                        class="no-underline text-brand group-hover:text-action"
                        href="{{ $note['permalink'] }}">
                        {!! $note['post_title'] !!}
                    </a>
                </h3>
                {!! $note['excerpt'] !!}
                <div class="flex flex-wrap gap-2 mt-4 relative z-30">
                    @foreach ($release_note_taxonomies as $index => $taxonomies)
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
                    @endforeach
                </div>
                @if ($note['permalink'])
                  <div class="absolute inset-0 rounded-t-lg z-20">
                    <a
                      class="no-underline absolute inset-0 font-bold text-xl text-brand"
                      href="{{ $note['permalink'] }}"
                      >
                      <span class="hidden not-sr-only" >{!! $note['post_title'] !!}</span>
                    </a>
                  </div>
                @endif
                </div>
          </div>
      @endforeach
		</div>
  </div>
</section>
