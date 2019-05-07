<?php

namespace App\Traits;

use App\Models\Description;

trait HasDescription {
  public function description() {
    return $this->descriptions()->where('active', '=', true)->first();
  }
  public function descriptions() {
    return $this->morphMany(Description::class, 'model');
  }
  public function addDescription(string $p_text, string $p_tag, bool $p_active = true) {
    if ($p_active) {
      $this->descriptions()->active()->update(['active' => false]);
    }
    $desc = new Description([
        'model_type' => get_class(),
        'model_id' => $this->id,
        'description' => $p_text,
        'tag' => $p_tag,
        'active' => $p_active]);
    $desc->save();
  }
}