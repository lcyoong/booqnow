<select name="{{ $name }}"
  @foreach(array_merge(['class' => 'form-control'], $attributes?: []) as $attrkey => $attrvalue)
  {{ $attrkey }} = "{{ $attrvalue }}"
  @endforeach
>
  <option>--</option>
  @foreach($list as $key => $label)
  <option @if ($key == $value) selected @endif value="{{ $key }}">{{ $label }}</option>
  @endforeach
</select>
