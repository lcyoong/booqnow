<div>
  @foreach($book_status as $key => $value)
  <i class="fa fa-circle status-{{ $key }}"></i> {{ $value }}
  @endforeach
</div>
