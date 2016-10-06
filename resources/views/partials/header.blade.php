<div class="container-fluid">
  @if(session()->has('merchant'))
  <h1>{{ session('merchant')->mer_name }}</h1>
  @endif
</div>
