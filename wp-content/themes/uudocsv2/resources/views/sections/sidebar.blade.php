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
<div class="sidebar hidden lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:w-72 lg:flex-col">
    <!-- Sidebar component -->
    <div class="flex grow flex-col gap-y-5 overflow-y-auto border-r border-gray-200 bg-white px-5 py-8">
        <div class="flex shrink-0 items-center px-2 mb-1">
            <a href="/">
                <span class="sr-only">Homepage</span>
                <img class="max-w-[183px]" src="@asset('/images/uudocs-logo.png')" alt="Unite Us Docs" />
            </a>
        </div>

        <!-- Always Show Searchbar and Log In Button -->
        <ul role="list" class="list-none mb-0">
            <li>@include('partials.content-search-modal')</li>
            <li class="bg-white rounded-md border-b border-pale-blue">
                <a href="https://app.uniteus.io/" target="_blank"
                    class="hover:bg-pale-blue no-underline items-center group flex gap-x-3 rounded-md p-2 text-sm font-semibold"
                    x-state:on="Current" x-state:off="Default">
                    <span
                        class="flex text-white h-8 w-8 shrink-0 items-center justify-center rounded-md border text-sm font-medium bg-action">
                        {{ svg('acf.external-link')->class('w-5 h-5') }}
                    </span>
                    <span class="text-action font-medium">Log in to the Platform</span>
                </a>
            </li>
        </ul>

        <!-- Full Sidebar (For Logged-In Users) -->
        <div class="sidebar full-sidebar">
          @include('partials.guide-side-nav')
        </div>

        <!-- Minimal Sidebar (For Public Guides and Public Resource Directory) -->
        <div class="sidebar minimal-sidebar">
          <ul role="list" class="list-none flex flex-col gap-y-2">
              <li>
                  <ul role="list" class="list-none">
                      <li>
                          <a href="/product/public-resource-directory/"
                              class="hover:bg-pale-blue no-underline items-center group flex gap-x-3 rounded-md p-2 text-sm font-semibold">
                              <span
                                  class="flex text-action h-8 w-8 shrink-0 items-center justify-center rounded-md border text-sm font-medium bg-white">
                                  {{ svg('acf.map')->class('w-5 h-5') }}
                              </span>
                              <span class="text-brand font-medium">Public Resource Directory</span>
                          </a>
                      </li>
                  </ul>
              </li>
          </ul>
        </div>
    </div>
</div>

<style>

/* Hide the full sidebar by default */
.full-sidebar {
  display: none;
}

/* Hide the minimal sidebar by default */
.minimal-sidebar {
  display: none;
}

/* If logged in, show full sidebar */
body.logged-in .full-sidebar {
  display: block;
}
body:not(.logged-in) .minimal-sidebar {
  display: block;
}
/* If NOT logged in AND on a public guide OR the Public Resource Directory, show minimal sidebar */
body:not(.logged-in).term-public-resource-directory .minimal-sidebar,
body:not(.logged-in).guide-section-public-resource-center-help-center .minimal-sidebar {
  display: block;
}

</style>