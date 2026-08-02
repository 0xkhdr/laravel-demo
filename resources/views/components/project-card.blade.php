<div class="card p-6">
  <h3 class="font-display text-xl font-bold mb-3">{{ $title }}</h3>

  @if ($description)
    <p class="text-secondary text-sm mb-4">{{ $description }}</p>
  @endif

  @if ($tags && count($tags) > 0)
    <div class="mb-6 flex flex-wrap gap-2">
      @foreach ($tags as $tag)
        <span class="skill-tag">{{ $tag }}</span>
      @endforeach
    </div>
  @endif

  <div class="flex gap-3">
    @if ($github)
      <a href="{{ $github }}" class="btn text-xs" target="_blank" rel="noopener">GitHub</a>
    @endif
    @if ($demo)
      <a href="{{ $demo }}" class="btn btn-accent text-xs" target="_blank" rel="noopener">Live Demo</a>
    @endif
  </div>
</div>
