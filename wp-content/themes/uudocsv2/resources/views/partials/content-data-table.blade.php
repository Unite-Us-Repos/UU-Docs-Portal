@php
$Parsedown = new Parsedown();

@endphp
@isset ($section["data"]["table"])
  <div class="flex flex-col">
    <div class="overflow-x-auto">

      <div class="block rounded-lg">
        <table class="acf-data-table w-full table-auto border-spacing-0 overflow-hidden border-separate rounded-lg border-solid border-2 border-action">
        @isset($section["data"]["table"]['caption'])
          <caption class="mb-4 ml-0.5 text-left">{!! $section["data"]["table"]['caption'] !!}</caption>
        @endif
            @isset ($section["data"]["table"]['header'])
              <thead class="bg-action">
                <tr>
                  @foreach ($section["data"]["table"]['header'] as $th)
                    <th scope="col" class="px-6 py-4 text-left text-xs uppercase text-white @if (!$loop->last) border-r border-light @endif @if ($loop->first) rounded-tl-md @endif @if ($loop->last) rounded-tr-md @endif">
                      <span class="tracking-widest">{{ $th['c'] }}</span>
                    </th>
                  @endforeach
                </tr>
              </thead>
            @endif

            @isset ($section["data"]["table"]['body'])
              <tbody class="bg-white">
                @foreach ($section["data"]["table"]['body'] as $index => $tr)
                  @if ($index % 2 == 0)
                    <tr>
                  @else
                    <tr class="bg-light ">
                  @endif

                  @foreach ($tr as $i => $td)
                    <td data-label="{{ $section['data']['table']['header'][$i]['c'] }}" class="align-top px-6 py-4 text-sm @if (!$loop->last) border-r border-light @endif">
                      <div class="cell-wrap">
                        {{-- Format cell data to html --}}
                        {!! $Parsedown->text($td['c']) !!}
                      </div>
                    </td>
                  @endforeach
                  </tr>
                @endforeach
              </tbody>
            @endif
          </table>
      </div>
    </div>
  </div>
  @endisset
