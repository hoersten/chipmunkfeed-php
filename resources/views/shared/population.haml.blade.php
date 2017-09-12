@if (isset($obj) && isset($obj->population))
%li
  %strong Population:
  {{ number_format($obj->population) }}
@endif