@if ($buttons)
  @php
    $layout = 'flex';
    $margin = 'ml-3';
    $show_arrow = false;

    if (!isset($justify)) {
      $justify = 'justify-center';
    }
    $button_layout = '';
    $component['style'] = '';
    if (isset($button_layout) && ('text' == $button_layout)) {
      $layout = 'grid grid-cols-2 gap-x-6';
      $margin = '';
      $show_arrow = true;
    }
    if (!isset($mt)) {
     $mt = false;
    }
  @endphp
  <div class="flex flex-wrap justify-center flex-col sm:flex-row gap-6 @if ('text' == $button_layout) mt-5 @elseif ('simple-justified' == $component['style'] && !$mt) mt-9 sm:mt-10 @elseif($mt) {{ $mt }} @else mt-9 sm:mt-10 @endif button-layout-{{ $button_layout }} {{ $layout }} lg:{{ $justify }}">
    @foreach ($buttons as $index => $button)
      @php
        if ('internal' == $button['link_type']) {
          $link = $button['page_link'];
        } else {
          $link = $button['link'];
        }

        if (isset($button_layout) && ('text' == $button_layout)) {
          $button['style'] = 'button-text';
        }
      @endphp
      @if ($index === 0)
        <div class="@if ('text' != $button_layout) inline-flex @endif">
          <a href="{{ $link }}" class="button w-full @isset ($button['icon']) flex items-center gap-3 @endif {{ $button['style'] }}" style="text-decoration:none !important;@if ('text' == $button_layout) padding: 0.75rem 0; @endif" @if ($button['is_blank']) target=="_blank" @endif>
            {{ $button["name"]}}
            @if ($show_arrow)
            <span aria-hidden="true"> &rarr;</span>
            @endif

            @isset ($button['icon'])
              @if ($button['icon'])
                {{ svg('acf.'.$button['icon'])->class('w-5 h-5') }}
              @endif
            @endisset
          </a>
        </div>
      @else
        <div class="@if ('text' != $button_layout) inline-flex @endif">
          <a href="{{ $link }}" class="button {{ $button['style'] }} flex items-center flex-1 gap-3 no-underline" style="text-decoration:none !important;@if ('text' == $button_layout) padding: 0.75rem 0; @endif" @if ($button['is_blank']) target=="_blank" @endif>
            {{ $button["name"]}}
            @if ($show_arrow)
            <span aria-hidden="true"> &rarr;</span>
            @endif
          </a>
        </div>
      @endif
    @endforeach
  </div>
@endif
