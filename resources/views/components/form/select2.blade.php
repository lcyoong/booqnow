<div class="col-md-{{ $col }}">
  <div class="form-group">
      {{ Form::label($name, $label, ['class' => 'control-label']) }}
      <div>
      <vue-select name="{{ $name }}"
        @foreach($attributes as $key => $value)
        {{ $key }} = "{{ $value }}"
        @endforeach
      >
        <option disabled value="">Select one</option>
      </vue-select>
      </div>
  </div>
</div>