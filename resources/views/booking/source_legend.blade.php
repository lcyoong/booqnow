<div class="pull-left" style="padding: 5px 20px">
  @foreach($sources as $key => $value)
  <i class="fa fa-square" style="background-color: #999999; color: {{ config('myapp.bg-source-' . $key) }}"></i> {{ $value }}
  @endforeach
</div>
