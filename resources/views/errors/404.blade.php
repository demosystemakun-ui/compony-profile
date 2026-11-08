@extends('layouts.app')

@section('title', 'Page not found | PT Patimban International Car Terminal')

@section('content')

<header class="page-head">
    <div class="shell">
        <p class="index"><b>404</b><span class="index-rule" aria-hidden="true"></span>Not found</p>
        <h1 class="display-l page-head__title">This page is not here.</h1>
        <p class="lede page-head__lede">
            The address may be out of date, or the page may have moved. The terminal information you need is still available from the pages below.
        </p>
    </div>
</header>

<section class="section section--tight section--paper">
    <div class="shell">
        <div class="btn-row">
            <a class="btn btn--primary" href="{{ url('/') }}">Back to home</a>
            <a class="btn btn--outline" href="{{ url('/contact') }}">Contact PICT</a>
        </div>
    </div>
</section>

@endsection
