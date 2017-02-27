<!-- <div class="col-md-{{ $col }}">
  <div class="form-group">
      {{ Form::label($name, $label, ['class' => 'control-label']) }}
      <div>
      {{ Form::select($name, $list, $value, array_merge(['class' => 'form-control'], $attributes?: [])) }}
      </div>
  </div>
</div> -->
<div class="col-md-{{ $col }}">
  <div class="form-group">
      {{ Form::label($name, $label, ['class' => 'control-label']) }}
      <div>
      <select name="{{ $name }}"
        @foreach(array_merge(['class' => 'form-control'], $attributes?: []) as $attrkey => $attrvalue)
        {{ $attrkey }} = "{{ $attrvalue }}"
        @endforeach
      >
        <option value="">--</option>
        @foreach($list as $key => $label)
        <option @if ($key == $value) selected @endif value="{{ $key }}">{{ $label }}</option>
        @endforeach
      </select>
      </div>
  </div>
</div>
