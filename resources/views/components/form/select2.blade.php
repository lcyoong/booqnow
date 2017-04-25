<div class="col-md-{{ $col }}">
  <div class="form-group">
      {{ Form::label($name, $label, ['class' => 'control-label']) }}
      <div>
      <vue-select name="{{ $name }}" class="select2"
        @foreach($attributes as $key => $value)
        {{ $key }} = "{{ $value }}"
        @endforeach
      >
      <option value="">--</option>
      </vue-select>
      </div>
  </div>
</div>
