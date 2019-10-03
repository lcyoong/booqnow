<div class="col-md-{{ $col }}">
  <div class="form-group">
      <!-- {{ Form::select($name, $list, $value, array_merge(['class' => 'form-control'], $attributes?: [])) }} -->
    <select name="{{ $name }}"
      @foreach(array_merge(['class' => 'form-control'], $attributes?: []) as $attrkey => $attrvalue)
      {{ $attrkey }} = "{{ $attrvalue }}"
      @endforeach
    >
      <option value="">-{{ $label ?? '' }}-</option>
      @foreach($list as $key => $value)
      <option @if ($key == $value) selected @endif value="{{ $key }}">{{ $value }}</option>
      @endforeach
    </select>
  </div>
</div>
