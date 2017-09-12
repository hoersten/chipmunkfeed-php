#header
  %nav.navbar.navbar-expand-md.navbar-toggler-right.navbar-light.bg-light{ role: 'navigation'}
    .container
      %a.navbar-brand{'href' => route('home')}
        //%img{'src' => mix('public/towntidbits.png'), 'alt' => 'TownTidbits'}
        TownTidbits
      %button.navbar-toggler{ 'type' => 'button', 'data-toggle' => 'collapse', 'data-target' => '#navbar', 'aria-controls' => 'navbar', 'aria-expanded' => 'false', 'aria-label' => 'Toggle navigation' }
        %span.navbar-toggler-icon
      #navbar.collapse.navbar-collapse
        %ul.navbar-nav.mr-auto
        %form#search_form.form-inline{ 'action' => route('search'), 'role' => 'search', 'method' => 'get' }
          %input.form-control{ 'name' => 'search_text', 'placeholder' => 'Search', 'autocomplete' => 'off' }
          %input{ 'type' => 'hidden', 'name' => 'auto_select', 'value' => false }
          @if (isset($state))
          %input{ 'type' => 'hidden', 'name' => 'state', 'value' => $state->id }
          @endif
          @if (isset($county))
          %input{ 'type' => 'hidden', 'name' => 'state', 'value' => $county->state->id }
          %input{ 'type' => 'hidden', 'name' => 'county', 'value' => $county->id }
          @endif
          %button.btn.btn-default Search
@include('layouts.status')