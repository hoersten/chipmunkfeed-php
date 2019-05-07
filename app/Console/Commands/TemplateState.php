<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\State;
use App\Models\Template;
use App\Services\Template as TemplateService;
use Carbon\Carbon;

class TemplateState extends Command {
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'template:state {--template=null} {state-abbreviation}';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Build descriptions from templates for states.';

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
    $template = $this->getTemplate();
    if ($state->count() > 1) {
      $this->error('Multiple states have the abbreviation ' . $this->argument('state-abbreviation'));
    } else if (!$template) {
      $this->error('Unknown template ' . $this->option('template') . ' for states.');
    } else if ($state->count() == 1) {
      $this->updateState($state->first(), $template);
    } else {
      $this->updateAllStates($template);
    }
  }

  /**
   * Updates the description for the given state.
   *
   * @param \App\Models\State $state
   * @return void
   */
  protected function updateState(State $state, Template $template) {
    $this->info('[' . Carbon::now()->toDateTimeString() . "] Updating $state->name ...");
    $this->templateService->buildStateDescription($state, $template);
  }

  /**
   * Updates the description for all states.
   *
   * @param \App\Models\Template $template
   * @return void
   */
  protected function updateAllStates(Template $template)  {
    if ($this->confirm('Are you sure you want to update templates for ALL states?')) {
      $this->info('[' . Carbon::now()->toDateTimeString() . '] Updating all states...');
      foreach(State::all() as $state) {
        $this->updateState($state, $template);
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
      return Template::where(['tag' => $this->option('template'), 'model_type' => State::class])->active()->first();
    }
    return Template::where(['model_type' => State::class])->active()->first();
  }
}
