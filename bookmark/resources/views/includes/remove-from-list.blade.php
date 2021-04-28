<form method='POST' id='remove-from-list' action='/list/{{ $book->slug }}/destroy'>
    {{ csrf_field() }}
    {{ method_field('delete') }}
    <a href='#' onClick='this.parentNode.submit();' dusk='{{ $book->slug }}-remove-from-list-button'><i class="fa fa-minus-circle"></i> Remove from your list</a>
</form>
