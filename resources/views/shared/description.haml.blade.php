@if (isset($obj) && $obj->description() != null)
.row
  .col-12
    %h2 Description:
    #{ $obj->description()->description }
@endif