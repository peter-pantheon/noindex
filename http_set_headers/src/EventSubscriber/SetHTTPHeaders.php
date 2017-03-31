<?php

/**
 * @file
 * Contains \Drupal\http_set_headers\EventSubscriber\SetHTTPHeaders.
 */

namespace Drupal\http_set_headers\EventSubscriber;

use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Provides SetHTTPHeaders.
 */
class SetHTTPHeaders implements EventSubscriberInterface {

  /**
   * Sets HTTP headers.
   */
  public function setHeader(FilterResponseEvent $event) {


    $param = 'X-Robots-Tag';
    $value = 'noindex';

    // Check if 404, 403
    if (!$event->isMasterRequest()) {
      return;
    }

    $request = $event->getRequest();
    $request_method = $request->server->get('HTTPS');

    if (isset($request_method) && filter_var($request_method, FILTER_VALIDATE_BOOLEAN)) {
      $response = $event->getResponse();
      $response->headers->set($param, $value);
    }

  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    $events[KernelEvents::RESPONSE][] = ['setHeader', 100];
    return $events;
  }

}
