@extends('layouts/main')

@section('title')
{{ $book ? $book->title : 'Book not found' }}
@endsection

@section('head')
<link href='/css/books/show.css' rel='stylesheet'>
@endsection

@section('content')

@if(!$book)
Book not found. <a href='/books'>Check out the other books in our library...</a>
@else
<img class='cover' src='{{ $book->cover_url }}' alt='Cover photo for {{ $book->title }}'>

<h1>{{ $book->title }}</h1>

@if($book->author)
<p dusk='author-info'>By {{ $book->author->first_name }} {{ $book->author->last_name }} ({{ $book->published_year}})</p>
@endif

<a href='{{ $book->purchase_url }}'>Purchase...</a>

<p class='description'>
    {{ $book->description }}
    <a href='{{ $book->info_url }}'>Learn more...</a>
</p>


<ul class='bookActions'>
    @if($onList)
    <li>
        @include('includes/remove-from-list')
    </li>
    @else
    <li>
        <a href='/list/{{ $book->slug }}/add' dusk='add-to-list-button'><i class="fa fa-plus"></i> Add to your list</a>
        @endif
    <li><a href='/books/{{ $book->slug }}/edit' dusk='edit-button'><i class="fa fa-edit"></i> Edit</a>
    <li><a href='/books/{{ $book->slug }}/delete' dusk='delete-button'><i class="fa fa-trash"></i> Delete</a>
</ul>

@endif

@endsection
