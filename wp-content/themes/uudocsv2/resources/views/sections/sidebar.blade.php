 <!-- Sidebar component, swap this element with another sidebar if you like -->
 <div class="flex grow flex-col gap-y-2 overflow-y-auto bg-white px-4">
            <div class="flex h-16 shrink-0 items-center px-2">
            <a href="/">
          <span class="sr-only">Homepage</span>
          <img class="max-w-[183px]" src="@asset('/images/uudocs-logo.png')" alt="Unite Us Docs" />
        </a>
            </div>
            @include('partials.guide-side-nav')

          </div>
        </div>

    </div>
  </div>


<!-- Static sidebar for desktop -->
<div class="hidden lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:w-72 lg:flex-col">
  <!-- Sidebar component, swap this element with another sidebar if you like -->
  <div class="flex grow flex-col gap-y-5 overflow-y-auto border-r border-gray-200 bg-white px-5 py-8">
    <div class="flex shrink-0 items-center px-2 mb-1">
    <a href="/">
          <span class="sr-only">Homepage</span>
          <img class="max-w-[183px]" src="@asset('/images/uudocs-logo.png')" alt="Unite Us Docs" />
        </a>
    </div>
    @include('partials.guide-side-nav')
  </div>
</div>

<div class="sticky top-0 z-40 flex justify-between gap-x-6 bg-white p-6 shadow-sm sm:px-6 lg:hidden">
<a href="/">
          <span class="sr-only">Homepage</span>
          <img class="max-w-[183px]" src="@asset('/images/uudocs-logo.png')" alt="Unite Us Docs" />
        </a>

  <button type="button" class="-m-2.5 p-2.5 text-gray-700 lg:hidden" @click="open = true">
    <span class="sr-only">Open sidebar</span>
    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
<path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"></path>
</svg>
  </button>

</div>
