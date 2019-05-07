<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\State;
use App\Models\County;
use App\Models\Template;
use App\Services\Template as TemplateService;
use Carbon\Carbon;

class TemplateCounty extends Command {
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'template:county {--template=null} {--county-slug=} {state-abbreviation}';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Build descriptions from templates for counties.';

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
    $template = $this->getTemplate();
    if ($state->count() > 1) {
      $this->error('Multiple states have the abbreviation ' . $this->argument('state-abbreviation'));
    } else if (!$template) {
      $this->error('Unknown template ' . $this->option('template') . ' for counties.');
    } else if ($state->count() == 1 && !empty($this->option('county-slug')) && $county->count() == 0) {
      $this->error('Unknown county "' . $this->option('county-slug') . '" for counties.');
    } else if ($state->count() == 1 && $county->count() == 1) {
      $this->updateCounty($state->first(), $county->first(), $template);
    } else {
      $this->updateByState($state->first(), $template);
    }
  }

  /**
   * Updates the description for all the counties in the given state.
   *
   * @param \App\Models\State $state
   * @param \App\Models\Template $template
   * @return void
   */
  protected function updateByState(State $state, Template $template) {
    if ($this->confirm("Are you sure you want to update templates for ALL counties in $state->name?")) {
      $this->info('[' . Carbon::now()->toDateTimeString() . "] Updating all counties in $state->name...");
      foreach($state->first()->counties()->get() as $county) {
        $this->updateCounty($state->first(), $county, $template);
      }
    }
  }

  /**
   * Updates the description for the given county.
   *
   * @param \App\Models\State $state
   * @param \App\Models\County $county
   * @param \App\Models\Template $template
   * @return void
   */
  protected function updateCounty(State $state, County $county, Template $template) {
    $this->info('[' . Carbon::now()->toDateTimeString() . "] Updating $county->name county in $state->name ...");
    $this->templateService->buildCountyDescription($county, $template);
  }

  /**
   * Gets the template for the given tag or the default.  May be null if not found.
   *
   * @return \App\Models\Template
   */
  protected function getTemplate() {
    if ($this->option('template') !== 'null') {
      return Template::where(['tag' => $this->option('template'), 'model_type' => County::class])->active()->first();
    }
    return Template::where(['model_type' => County::class])->active()->first();
  }
}
