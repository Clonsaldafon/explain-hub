@if(count($tags))
  <div class="tags">
      <ul class="tags__list">
          @foreach($tags as $tag)
              <li class="tags__item">#{{ $tag->name }}</li>
          @endforeach
      </ul>
  </div>
@endif