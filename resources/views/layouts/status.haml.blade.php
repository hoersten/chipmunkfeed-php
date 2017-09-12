@if (session()->get('status'))
.container
  .row
    .col-12
      %div.alert{ 'class' => "alert-#{(session()->get('status-level') ?  session()->get('status-level') : 'danger')}", "role"=>"alert"}
        #{session()->get('status')}
@endif
@if ($errors->any())
.container
  .row
    .col-12
      %div.alert.alert-danger
        %ul
          @foreach ($errors->all() as $error)
          %li {{ $error }}
          @endforeach
@endif