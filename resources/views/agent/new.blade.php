@extends($layout)

@prepend('content')
<div id="agent-new">
<form-ajax action = "{{ urlTenant('agents/new') }}" method="POST" redirect-on-complete="{{ urlTenant('agents') }}" @startwait="startWait" @endwait="endWait">
  <div class="row">
    {{ Form::bsText('ag_name', trans('agent.ag_name')) }}
    {{ Form::bsSelect('ag_type', trans('agent.ag_type'), $ag_type) }}
    <!-- {{ Form::bsText('ag_remarks', trans('agent.ag_remarks')) }} -->
  </div>
  {{ Form::submit(trans('form.save'), ['class' => 'btn btn-primary btn-sm', ':disabled' => 'waiting']) }}
  <redirect-btn label="@lang('form.cancel')" redirect="{{ urlTenant('agents') }}" class="btn-sm"></redirect-btn>
</form-ajax>
</div>
@endprepend

@prepend('scripts')
<script>
new Vue ({

  el: "#agent-new",

  mixins: [mixForm],

  data: {
  },

  methods: {
  }

})

</script>
@endprepend
