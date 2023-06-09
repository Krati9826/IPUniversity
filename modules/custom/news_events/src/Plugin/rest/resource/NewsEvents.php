<?php
 namespace Drupal\news_events\Plugin\rest\resource;

use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ResourceResponse;
use Psr\Log\LoggerInterface;
use Drupal\Core\Session\AccountProxyInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
/**
 * Provides a resource to get view modes by entity and bundle.
 * @RestResource(
 *   id = "custom_news_events",
 *   label = @Translation("Custom news events Resource"),
 *   uri_paths = {
 *     "canonical" = "news/events",
 *   }
 * )
 */
class SampleGetRestResource extends ResourceBase {
  /**
   * Responds to entity GET requests.
   * @return \Drupal\rest\ResourceResponse
   */
    public function get() {
      $nid =  \Drupal::request()->query->get('nid');
      foreach ($nid as $key=>$value) {        
         $nodes[$key] =  \Drupal\node\Entity\Node::load($nid[$key]);        
        }
     
      return new ResourceResponse($nodes);
    }
      
  }
    
  