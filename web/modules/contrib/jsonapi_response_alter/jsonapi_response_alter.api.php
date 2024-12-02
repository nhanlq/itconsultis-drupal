<?php

/**
 * @file
 * Hooks provided by the JSON:API Response Alter module.
 */

use Symfony\Component\HttpFoundation\Response;

/**
 * @addtogroup hooks
 * @{
 */

/**
 * Alters the JSON:API response.
 *
 * @param array $jsonapi_response
 *   The decoded JSON data to be altered.
 * @param \Symfony\Component\HttpFoundation\Response $response
 *   The response.
 */
function hook_jsonapi_response_alter(array &$jsonapi_response, Response $response) {
  // Do some altering here.
}
