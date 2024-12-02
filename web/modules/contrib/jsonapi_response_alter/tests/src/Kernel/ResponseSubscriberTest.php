<?php

namespace Drupal\Tests\jsonapi_response_alter\Functional\EventSubscriber;

use Drupal\Component\Serialization\Json;
use Drupal\Tests\BrowserTestBase;

/**
 * Class ResponseSubscriberTest.
 *
 * Tests the ResponseSubscriber class.
 *
 * @package Drupal\Tests\jsonapi_response_alter\Functional\EventSubscriber
 * @group jsonapi_response_alter
 */
class ResponseSubscriberTest extends BrowserTestBase {

  /**
   * {@inheritdoc}
   */
  protected static $modules = [
    'jsonapi',
    'jsonapi_response_alter',
    'jsonapi_response_alter_test',
  ];

  /**
   * {@inheritdoc}
   */
  protected $defaultTheme = 'stark';

  /**
   * TestJsonApiResponseAltered.
   */
  public function testJsonApiResponseAltered(): void {
    $document = Json::decode($this->drupalGet('/jsonapi'));
    $this->assertTrue(isset($document['jsonapi_response_alter_test_by_hook_jsonapi_response_alter']));
    $this->assertTrue(isset($document['jsonapi_response_alter_test_by_event_subscriber']));

  }

}
