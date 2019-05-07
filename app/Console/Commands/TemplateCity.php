<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\State;
use App\Models\County;
use App\Models\City;
use App\Models\Template;
use App\Services\Template as TemplateService;
use Carbon\Carbon;

class TemplateCity extends Command {
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'template:city {--template=null} {--county-slug=} {--city-slug=} {state-abbreviation}';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Build descriptions from templates for cities.';

  /**
   * Create a new command instance.
   *
   * @return void
   */
  public function __construct() {
    parent::__construct();
    $this->templateService = new TemplateService();
  }

  /**
   * Execute the console command.
   *
   * @return mixed
   */
  public function handle() {
    $state = State::where(['abbreviation' => $this->argument('state-abbreviation')])->get();
    $county = County::where(['slug' => $this->option('county-slug')])->get();
    $city = City::where(['slug' => $this->option('city-slug')])->get();
    $template = $this->getTemplate();
    if ($state->count() > 1) {
      $this->error('Multiple states have the abbreviation ' . $this->argument('state-abbreviation'));
    } else if (!$template) {
      $this->error('Unknown template ' . $this->option('template') . ' for cities.');
    } else if ($state->count() == 1 && !empty($this->option('county-slug')) && $county->count() == 0) {
      $this->error('Unknown county "' . $this->option('county-slug') . '" for cities.');
    } else if ($state->count() == 1 && !empty($this->option('city-slug')) && $city->count() == 0) {
      $this->error('Unknown city "' . $this->option('city-slug') . '" for cities.');
    } else if ($state->count() == 1 && $county->count() == 1) {
      $this->updateByCounty($state->first(), $county->first(), $template);
    } else if ($state->count() == 1 && $city->count() == 1) {
      $this->updateCity($state->first(), $city->first(), $template);
    } else {
      $this->updateByState($state->first(), $template);
    }
  }

  /**
   * Updates the description for a given city.
   *
   * @param \App\Models\State $state
   * @param \App\Models\City $city
   * @param \App\Models\Template $template
   * @return void
   */
  protected function updateCity(State $state, City $city, Template $template) {
    $this->info('[' . Carbon::now()->toDateTimeString() . "] Updating $city->name city in $state->name ...");
    $this->templateService->buildCityDescription($city, $template);
  }

  /**
   * Updates the description for all cities in the given county.
   *
   * @param \App\Models\State $state
   * @param \App\Models\County $county
   * @param \App\Models\Template $template
   * @return void
   */
  protected function updateByCounty(State $state, County $county, Template $template) {
    if ($this->confirm("Are you sure you want to update templates for ALL cities in $county->name?")) {
      $this->info('[' . Carbon::now()->toDateTimeString() . "] Updating all cities in $county->name...");
      foreach($county->cities()->get() as $city) {
        $this->updateCity($state, $city, $template);
      }
    }
  }

  /**
   * Updates the description for all cities in the given state.
   *
   * @param \App\Models\State $state
   * @param \App\Models\Template $template
   * @return void
   */
  protected function updateByState(State $state, Template $template) {
    if ($this->confirm("Are you sure you want to update templates for ALL cities in $state->name?")) {
      $this->info('[' . Carbon::now()->toDateTimeString() . "] Updating all cities in $state->name...");
      foreach($state->cities()->get() as $city) {
        $this->updateCity($state, $city, $template);
      }
    }
  }

  /**
   * Gets the template for the given tag or the default.  May be null if not found.
   *
   * @return \App\Models\Template
   */
  protected function getTemplate() {
    if ($this->option('template') !== 'null') {
      return Template::where(['tag' => $this->option('template'), 'model_type' => City::class])->active()->first();
    }
    return Template::where(['model_type' => City::class])->active()->first();
  }
}
