%footer
  .container.text-center
    &copy; 2017

%script{ 'src' => mix('/js/app.js') }
%script{ 'src' => "https://www.google.com/jsapi?autoload={'modules':[{'name':'visualization','version':'1','packages':['geochart','map','corechart']}]}" }
%script{ 'src' => 'https://maps.google.com/maps/api/js?sensor=false' }
