@extends('layouts.master)

@push('vars')
<?php
$pageTitle = 'All topics - Amazon Scraper';
$bodyClass = 'keyword-list';
?>
@endpush

@section('header')
  <header>
    <h1><a href="{{ action('PageController@keywords') }}">
        All Topics
      </a></h1>
  </header>
@endsection

@section('main')

@endsection
