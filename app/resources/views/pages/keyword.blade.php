@extends('layouts.master')

@push('vars')
<?php
  $pageTitle = e($keyword->term) . ' - Amazon Scraper';
  $bodyClass[] = 'keyword';
?>
@endpush

@section('header')
  <header class="global">
    <a href="{{ url('/') }}">Back to home</a>
    <h1><a href="{{ action('PageController@keyword', ['keyword' => $keyword->slug]) }}">
        {{ $keyword->term }}</a></h1>
  </header>
@endsection

@section('main')
  <div class="book-list">
    @each('shared.book', $keyword->books, 'book')
  </div>
@endsection
