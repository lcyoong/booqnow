<?php

namespace App\Listeners;

use App\Events\ModelCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Repositories\AuditTrailRepository;
use App\AuditTrail;

class AuditLogCreated
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
   * @param  ModelCreated  $event
   * @return void
   */
  public function handle(ModelCreated $event)
  {
    if ($event->post['audit']) {

      $auditTrail = new AuditTrail([
        // 'au_model_type' => get_class($event->post),
        // 'au_model_id' => $event->post->{$event->post->getKeyName()},
        'au_mode' => 'created',
        'au_data' => serialize(array_diff($event->post['attributes'], $event->post['original']))
      ]);

      $event->post->auditTrails()->save($auditTrail);

      // $this->repo->store([
      //   'au_model' => get_class($event->post),
      //   'au_model_id' => $event->post['attributes'][$event->post->getKeyName()],
      //   'au_mode' => 'created',
      //   'au_data' => serialize($event->post['attributes'])
      // ]);

    }
  }
}
