<?php

namespace App\Services;
use App\Models\State;
use App\Models\County;
use App\Models\City;
use App\Models\Description;

class Template {
  public function buildStateDescription(State $state, \App\Models\Template $template) {
    $text = $this->processTemplate($template->template, $state);
    $tag = $template->tag;
    $state->addDescription($text, $tag);
  }

  public function buildCountyDescription(County $county, \App\Models\Template $template) {
    $text = $this->processTemplate($template->template, $county);
    $tag = $template->tag;
    $county->addDescription($text, $tag);
  }

  public function buildCityDescription(City $city, \App\Models\Template $template) {
    $text = $this->processTemplate($template->template, $city);
    $tag = $template->tag;
    $city->addDescription($text, $tag);
  }

  protected function processTemplate(string $template, $obj) {
    $s = preg_replace_callback('{{% ([\w\-\d]+) %}}', function(array $matches) use ($obj) {
      $function = $matches[1];
      if (is_callable(array($obj, $function))) {
        return $obj->$function;
      }
      return "";
    }, $template);
    return $s;
  }
}
