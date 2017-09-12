%head
  %title
    @section('title')
    @show
  %meta{ "charset" => "utf-8" }
  %meta{ "http-equiv" => "X-UA-Compatible", "content" => "IE=edge" }
  %meta{ "name" => "viewport", "content" => "width=device-width, initial-scale=1" }
  %meta{ "name" => "csrf-token", "content" => csrf_token() }

  %link{ 'href' => mix('/css/app.css'), 'media' => 'all', 'rel' => 'stylesheet' }
  %link{ 'href' => 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css', 'rel' => 'stylesheet' }

  %meta{ "name" => "csrf-token", "content" => csrf_token() }
  %script
    window.Laravel = {!! json_encode([ 'csrfToken' => csrf_token(), ]) !!};
