@extends($layout)

@prepend('content')
<div id="agent-edit">
<form-ajax action = "{{ urlTenant('agents/update') }}" method="POST" redirect-on-complete="{{ urlTenant('agents') }}" @startwait="startWait" @endwait="endWait">
  {{ Form::hidden('ag_id', $agent->ag_id) }}
  <div class="row">
    {{ Form::showField($agent->ag_id, trans('agent.ag_id')) }}
    {{ Form::showField($agent->creator->name, trans('form.created_by')) }}
    {{ Form::showField($agent->created_at, trans('form.created_at')) }}
  </div>
  <div class="row">
    {{ Form::bsText('ag_name', trans('agent.ag_name'), $agent->ag_name) }}
    {{ Form::bsText('ag_remarks', trans('agent.ag_remarks'), $agent->ag_remarks) }}
    {{ Form::bsSelect('ag_status', trans('agent.ag_status'), $rs_status, $agent->ag_status) }}
  </div>
  {{ Form::submit(trans('form.save'), ['class' => 'btn btn-primary btn-sm', ':disabled' => 'waiting']) }}
  <redirect-btn label="@lang('form.cancel')" redirect="{{ urlTenant('agents') }}" class="btn-sm"></redirect-btn>
</form-ajax>
</div>
@endprepend

@prepend('scripts')
<script>
new Vue ({

  el: "#agent-edit",

  mixins: [mixForm],

  data: {
  },

  methods: {
  }

})

</script>
@endprepend
