!!! 5
%html{ "lang" => config('app.locale') }
  @include('layouts.head')
  %body{ "class" => request()->route()->getAction(), 'itemscope' => 'itemscope', 'itemtype' => 'http://schema.org/WebPage' }
    #main-container
      @include('layouts.body_header')
      %section.content
        .container
          @yield('content')
      @include('layouts.body_footer')