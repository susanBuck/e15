@extends('layouts/main')

@section('title')
{{ $title }}
@endsection

@section('head')
<link href='/css/books/show.css' rel='stylesheet'>
@endsection

@section('content')
<h1>{{ $title }}</h1>

<p>
    Details about this book will go here...
</p>
@endsection