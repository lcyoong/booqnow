<div class="pull-left" style="padding: 5px 20px">
  @foreach($book_status as $key => $value)
  <i class="fa fa-circle status-{{ $key }}"></i> {{ $value }}
  @endforeach
</div>
