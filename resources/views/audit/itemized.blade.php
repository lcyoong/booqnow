@if(count($items) > 0)
<ul class="list-group">
  @foreach($items as $item)
  <li class="list-group-item">
    <span class="label label-default">{{ $item->au_mode }} at {{ $item->created_at }} by {{ $item->creator->name }}</span>
    <div>
      @foreach(unserialize($item->au_data) as $field => $value)
        <span class="label label-success">{{ $field }}: {{ $value }}</span>
      @endforeach
    </div>
  </li>
  @endforeach
</ul>
@else
<div class="v_margin_10"><span class="label label-danger">@lang('form.no_item')</span></div>
@endif
