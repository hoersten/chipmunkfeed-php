@if (isset($obj) && (isset($obj->wikipedia) || isset($obj->twitter) || isset($obj->url)))
%h2
  Web Links
%ul
  @if(isset($obj->wikipedia))
  %li
    %a{'href' => $obj->wikipedia, 'target' => '_blank'} Wikipedia
  @endif
  @if(isset($obj->twitter))
  %li
    %a{'href' => $obj->twitter, 'target' => '_blank'} Twitter
  @endif
  @if(isset($obj->url))
  %li
    %a{'href' => $obj->url, 'target' => '_blank'} Official Homepage
  @endif
@endif