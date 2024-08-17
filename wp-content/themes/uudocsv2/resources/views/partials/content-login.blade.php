<section class="component-section">
<div class="component-inner-section">
<div class="lg:grid lg:grid-cols-2 lg:gap-32">
  <div class="mx-auto max-w-md px-4 sm:max-w-2xl sm:px-6 sm:text-center lg:px-0 lg:text-left lg:flex lg:items-center">
    <div class="lg:py-14">
      <h1 class="mt-4 text-4xl tracking-tight font-extrabold sm:mt-5 sm:text-6xl lg:mt-6 xl:text-6xl">
        <span class="block">This content is protected</span>
      </h1>
      <p class="text-lg">
        This content is password protected for licensed Unite Us network partners. To view it, please enter your Unite Us Docs 
        password below or contact your Unite Us point of contact.
      </p>
      <div class="mt-10 sm:mt-12">
        {!! $loginForm !!}
        <div class="flex p-2 gap-4 mt-4">
          <a class="text-action no-underline" href="/register/">Register</a>
          <a class="text-action no-underline" href="/reset-password/">Forgot Password?</a>
        </div>
      </div>
    </div>
  </div>
  <div class="flex items-center justify-center mt-12 lg:m-0 relative">
    <div class="mx-auto max-w-md p-10 sm:max-w-2xl sm:px-6 lg:max-w-none lg:px-0">
      <img class="w-full h-auto" src="@asset('/images/protected-lock.png')" alt="" />
    </div>
  </div>
</div>
</div>
</section>
