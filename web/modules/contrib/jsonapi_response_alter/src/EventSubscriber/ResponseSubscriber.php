<?php

namespace Drupal\jsonapi_response_alter\EventSubscriber;

use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\jsonapi\Routing\Routes;
use Drupal\jsonapi_response_alter\Event\JsonApiResponseAlterEvent;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

/**
 * Class ResponseSubscriber.
 *
 * Implements the alter hook for JSON:API responses.
 *
 * @package Drupal\jsonapi_response_alter\EventSubscriber
 */
class ResponseSubscriber implements EventSubscriberInterface, ContainerInjectionInterface {

  /**
   * The module handler.
   *
   * @var \Drupal\Core\Extension\ModuleHandlerInterface
   */
  protected $moduleHandler;

  /**
   * The route match service.
   *
   * @var \Drupal\Core\Routing\RouteMatchInterface
   */
  protected $routeMatch;

  /**
   * The event dispatcher.
   *
   * @var \Symfony\Contracts\EventDispatcher\EventDispatcherInterface
   */
  protected $eventDispatcher;

  /**
   * ResponseSubscriber constructor.
   *
   * @param \Drupal\Core\Extension\ModuleHandlerInterface $moduleHandler
   *   The module handler.
   * @param \Symfony\Contracts\EventDispatcher\EventDispatcherInterface $eventDispatcher
   *   The event dispatcher.
   */
  public function __construct(ModuleHandlerInterface $moduleHandler, EventDispatcherInterface $eventDispatcher) {
    $this->moduleHandler = $moduleHandler;
    $this->eventDispatcher = $eventDispatcher;
  }

  /**
   * Create a new instance.
   *
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
   *   The container.
   *
   * @return \Drupal\jsonapi_response_alter\EventSubscriber\ResponseSubscriber
   *   The new instance.
   */
  public static function create(ContainerInterface $container) {
    return new self(
      $container->get('module_handler'),
      $container->get('event_dispatcher')
    );
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents(): array {
    $events[KernelEvents::RESPONSE] = ['onResponse'];

    return $events;
  }

  /**
   * Set route match service.
   *
   * @param \Drupal\Core\Routing\RouteMatchInterface $route_match
   *   The  route match service.
   */
  public function setRouteMatch(RouteMatchInterface $route_match) {
    $this->routeMatch = $route_match;
  }

  /**
   * This method is called the KernelEvents::RESPONSE event is dispatched.
   *
   * @param \Symfony\Component\HttpKernel\Event\ResponseEvent $event
   *   The filter event.
   */
  public function onResponse(ResponseEvent $event) {
    if (!$this->routeMatch->getRouteObject()) {
      return;
    }

    if (
      $this->routeMatch->getRouteObject()
        ->getDefault(Routes::JSON_API_ROUTE_FLAG_KEY) ||
      Routes::isJsonApiRequest($this->routeMatch->getRouteObject()
        ->getDefaults())
    ) {
      $response = $event->getResponse();
      $content = $response->getContent();

      $jsonapi_response = json_decode($content, TRUE);

      if (!is_array($jsonapi_response)) {
        return;
      }

      // Alter using hook_jsonapi_response_alter.
      $this->moduleHandler->alter('jsonapi_response', $jsonapi_response, $response);

      // Alter using event subscribers.
      $event = $this->eventDispatcher->dispatch(new JsonApiResponseAlterEvent($jsonapi_response, $response));

      $response->setContent(json_encode($event->jsonapiResponse));
    }
  }

}
