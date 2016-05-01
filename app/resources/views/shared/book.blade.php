<?php $id = 'book-' . $book->id ?>
<div class="book-item collapsed" role="button" data-toggle="collapse" data-target="#{{ $id }}"
     aria-expanded="false" aria-controls="{{ $id }}">
    <img src="{{ $book->cover_url }}" alt="">
</div>

<div id="{{ $id }}" class="collapse book-info container-fluid">
  <div class="row">
    <div class="col-md-6">
      <h2><a href="{{ $book->url }}">{{ $book->title }}</a></h2>

      @unless(empty($book->authors))
        <p class="byline">by
          @foreach($book->authors as $author)
            @if ($url = $author->url)
              <a href="{{ $url }}">{{ $author->name }}</a>
            @else
              <strong>{{ $author->name }}</strong>
            @endif
          @endforeach

          @unless(empty($book->rating))
            | Rating: <strong>{{ $book->rating }}</strong> out of 5
          @endunless
        </p>
      @endunless

      @unless(empty($book->description))
        <div class="book-desc">
          {!! $book->description !!}
        </div>
      @endunless
    </div>

    <div class="col-md-6">
      @unless(empty($book->prices))
        <div class="price">
          <h3>Prices</h3>
          @foreach($book->prices as $price)
            <p>{{ $price->edition }}
              <strong>@price($price->price)</strong></p>
          @endforeach

          <a class="btn btn-primary btn-block btn-lg" href="{{ $book->url }}">
            Buy on Amazon</a>
        </div>
      @endunless

      @unless(empty($bios = array_pluck($book->authors, 'bio', 'name')))
        <h3>About the Author</h3>
        @foreach($bios as $name => $bio)
        <div>
          @if(count($bios) > 1)
            <h4>{{ $name }}</h4>
          @endif
          <p>{{ $bio }}</p>
        </div>
        @endforeach
      @endunless
    </div>

  </div>

</div>
