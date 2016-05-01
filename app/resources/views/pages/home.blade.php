@extends('layouts.master')

@push('vars')
<?php
  $pageTitle = 'Home - Amazon Scraper';
  $bodyClass[] = 'home';
?>
@endpush

@section('header')
  <header class="global">
    <h1><a href="{{ url('/') }}">Judge a Book By Its Cover</a></h1>
    <p>Find new books. Interest based. Fresh from Amazon.</p>
    <p class="topics">
      <strong>Topics: </strong>
      @foreach($keywords as $keyword)
      <a href="{{ action('PageController@keyword', ['keyword' => $keyword->slug]) }}">
        {{ $keyword->term }}
      </a>
      @endforeach
    </p>
  </header>
@endsection

@section('main')
  <div class="book-list">
    @each('shared.book', $books, 'book')
  </div>
@endsection