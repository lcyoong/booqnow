<div>
  @foreach($data as $field => $value)
    <span class="label label-success">{{ $field }}: {{ $value }}</span>
  @endforeach
</div>
