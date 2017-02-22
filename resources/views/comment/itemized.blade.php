<!-- @if(count($items) > 0) -->
<ul class="list-group">
  <li class="list-group-item" v-for="item in items">
    @{{ item.com_content }}
  </li>
</ul>
<!-- @else -->
<!-- <div class="v_margin_10"><span class="label label-danger">@lang('form.no_item')</span></div>
@endif -->
