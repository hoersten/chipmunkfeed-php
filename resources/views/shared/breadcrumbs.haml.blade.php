@if (isset($breadcrumbs))
.row#breadcrumb
  .col-12
    %ol.breadcrumb
      @foreach($breadcrumbs as $breadcrumb)
      @if(empty($breadcrumb['active']))
      %li.breadcrumb-item
        %a{ 'href' => $breadcrumb['url'] } #{ $breadcrumb['text'] }
      @else
      %li.breadcrumb-item.active
        #{ $breadcrumb['text'] }
      @endif
      @endforeach
      %script{ "type" => "application/ld+json"}
        :plain
          {
           "@context": "http://schema.org",
           "@type": "BreadcrumbList",
           "itemListElement":
           [
        @foreach($breadcrumbs as $index => $breadcrumb)
        :plain
            {
             "@type": "ListItem",
             "position": #{ $index },
             "item":
             {
              "@id": "#{ $breadcrumb['url']}",
              "@type": "WebPage",
              "name": "#{ $breadcrumb['text']}"
              }
            }
        @if(empty($breadcrumb['active']))
        :plain
          ,
        @endif
        @endforeach
        :plain
           ]
          }
@endif