@if(auth()->check())
<div class="pull-left">{{ Form::button('*Create your first merchant account', ['class' => 'btn btn-primary']) }}</div>
@endif
