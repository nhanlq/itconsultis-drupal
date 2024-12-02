<?php

namespace Drupal\jsonapi_response_alter_test;

use Drupal\jsonapi_response_alter\Event\JsonApiResponseAlterEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Event subscriber to test JsonApiResponseAlterEvents.
 */
class EventSubscriber implements EventSubscriberInterface {

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents(): array {
    $events[JsonApiResponseAlterEvent::class] = 'onJsonApiResponseAlterEvent';

    return $events;
  }

  /**
   * Alter the JSON:API response.
   *
   * @param \Drupal\jsonapi_response_alter\Event\JsonApiResponseAlterEvent $event
   *   The event.
   */
  public function onJsonApiResponseAlterEvent(JsonApiResponseAlterEvent $event) {
    $event->jsonapiResponse['jsonapi_response_alter_test_by_event_subscriber'] = TRUE;
  }

}
