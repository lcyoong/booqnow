<?php

namespace App\Listeners;

use App\Events\ModelUpdated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Repositories\AuditTrailRepository;

class AuditLogUpdated
{
  protected $repo;

  /**
  * Create the event listener.
  *
  * @return void
  */
  public function __construct(AuditTrailRepository $repo)
  {
    $this->repo = $repo;
  }

  /**
  * Handle the event.
  *
  * @param  ModelUpdated  $event
  * @return void
  */
  public function handle(ModelUpdated $event)
  {
    if ($event->post['audit']) {

      $auditTrail = new \App\AuditTrail([
        // 'au_model_type' => get_class($event->post),
        // 'au_model_id' => $event->post->{$event->post->getKeyName()},
        'au_mode' => 'updated',
        'au_data' => serialize(array_diff($event->post['attributes'], $event->post['original']))
      ]);

      $event->post->auditTrails()->save($auditTrail);

      // $this->repo->store([
      //   'au_model_type' => get_class($event->post),
      //   'au_model_id' => $event->post->{$event->post->getKeyName()},
      //   'au_mode' => 'updated',
      //   'au_data' => serialize(array_diff($event->post['attributes'], $event->post['original']))
      // ]);

    }
  }
}
