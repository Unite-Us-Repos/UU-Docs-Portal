@php
$title = isset($acf['hero']['title']) ? $acf['hero']['title'] : '';
$description = isset($acf['hero']['description']) ? $acf['hero']['description'] : '';
$image = isset($acf['hero']['image']) ? $acf['hero']['image'] : [];
$buttons = isset($acf['hero']['buttons']) ? $acf['hero']['buttons'] : [];
@endphp
@isset ($acf['hero'])
<section class="component-section mb-12 sm:mb-16">
  <div class="component-inner-section relative">
    <div class="relative flex flex-col items-center sm:grid grid-cols-12 gap-10 text-white bg-brand p-4 sm:p-12 rounded-2xl overflow-hidden">
      <div class="absolute inset-0 z-0" style="background: url(@asset('/images/header-bg.png')) center center; background-size: cover;">
      </div>
      <div class="col-span-8 text-center order-2 sm:text-left sm:order-1 z-10">
        <h1 class="text-3xl sm:text-5xl mb-5">{!! $title !!}</h1>
        <div class="text-lg font-medium max-w-lg">{!! $description !!}</div>
      </div>
      <div class="col-span-4 order-1 sm:order-3 z-10">
        @if ($image)
          <div>
            <img class="mx-auto w-full h-auto max-w-[194px] xl:max-w-[225px]"
              src="{{ $image['sizes']['medium_large'] }}"
              alt="{{ $image['alt'] }}" />
          </div>
        @endif
      </div>
    </div>
  </div>
</section>
@endisset

<section class="component-section mb-12 sm:mb-16">
  <div class="component-inner-section">
    <div id="kh-top">
          <div id="ajax-filters" class="relative z-40">
            {!! do_shortcode('[searchandfilter slug="release-notes"]') !!}
          </div>
        </div>

        <div id="filterBadges" class="relative flex flex-wrap items-center gap-y-4 py-10 z-10"></div>

      <div id="kb-search-results">
        {!! do_shortcode('[searchandfilter slug="release-notes" show="results"]') !!}
      </div>
  </div>
</section>

<script>
jQuery().ready(function($) {
  $('body').on('click', '.remove-cat-filter', function() {
    var sThisId = $(this).data('cat-id');
    var isRadio = $(this).hasClass('is-radio');
    $('#' + sThisId).click();
    if (isRadio) {
      console.log('is radio');
      $('#' + sThisId).parents('ul').find('.sf-input-radio').eq(0).click();
    }
  });

  $(document).on("sf:ajaxfinish", ".searchandfilter", function() {
    setBadges();
    lazyLoadInstance.update(); // refresh lazy loading on ajax call
  });

  setBadges();

  function setBadges() {
    $('#filterBadges').html('');

    $('.sf-input-checkbox').each(function () {
        var radioClass = '';
        if ($(this).hasClass('sf-input-radio')) {
          radioClass = 'is-radio';
        }
        var sThisVal = (this.checked ? $(this).val() : "");
        var sThisId  = (this.checked ? $(this).attr('id') : "");
        var sThisName  = (this.checked ? $(this).attr('name') : "");
        var sThisLabel  = (this.checked ? $(this).next('label').text() : "");
        sThisName = sThisName.replace('_sft_', '');
        sThisName = sThisName.replace('[]', '');
        var badge = '<button type="button" data-cat-id="' + sThisId + '" class="remove-cat-filter group bg-marketing-' + sThisName + '/10 '  + radioClass + ' inline-flex items-center rounded shadow-sm hover:shadow-md py-0.5 pl-2.5 pr-1 text-sm font-medium mr-3">' + sThisLabel + '<span  class="ml-0.5 inline-flex h-4 w-4 flex-shrink-0 items-center justify-center rounded-full group-hover:cursor-pointer group-hover:bg-white focus:bg-blue-200 focus:outline-none"><span class="sr-only">Remove ' + sThisVal + '</span><svg class="h-2 w-2 text-marketing-' + sThisName + '" stroke="currentColor" fill="none" viewBox="0 0 8 8"><path stroke-linecap="round" stroke-width="1.5" d="M1 1l6 6m0-6L1 7" /></svg></span></button>';
console.log(sThisName);
        if (sThisVal) {
          $('#filterBadges').append(badge);
        }
    });
  }
});
</script>
