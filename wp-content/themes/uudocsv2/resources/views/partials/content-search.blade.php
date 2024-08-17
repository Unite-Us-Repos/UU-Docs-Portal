<article @php(post_class('mb-9'))>
  <header>
    <h2 class="entry-title text-2xl font-semibold">
      <a href="{{ get_permalink() }}" class="no-underline">
        {!! $title !!}
      </a>
    </h2>

    @includeWhen(get_post_type() === 'post', 'partials.entry-meta-search')
  </header>

  <div class="entry-summary text-lg">
    @php(the_excerpt())
  </div>
</article>
