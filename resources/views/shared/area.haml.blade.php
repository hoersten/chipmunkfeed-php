@if (isset($obj) && isset($obj->area))
%li
  %strong Area:
  {{ number_format($obj->area) }} mi<sup>2</sup>
@endif
