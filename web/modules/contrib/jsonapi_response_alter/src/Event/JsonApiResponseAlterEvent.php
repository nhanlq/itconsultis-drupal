<?php

namespace Drupal\jsonapi_response_alter\Event;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * Event dispatched to be used to alter the JSON:API response.
 */
class JsonApiResponseAlterEvent extends Event {

  /**
   * The JSON:API response data.
   *
   * @var array
   */
  public $jsonapiResponse;

  /**
   * The initial response object.
   *
   * @var \Symfony\Component\HttpFoundation\Response
   */
  public $response;

  /**
   * Constructs a new JsonApiResponseAlterEvent instance.
   *
   * @param array $jsonapiResponse
   *   The JSON:API response data.
   * @param \Symfony\Component\HttpFoundation\Response $response
   *   The initial response object.
   */
  public function __construct(array $jsonapiResponse, Response $response) {
    $this->jsonapiResponse = $jsonapiResponse;
    $this->response = $response;
  }

}
