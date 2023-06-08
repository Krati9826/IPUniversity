<?php
 namespace Drupal\news_events_view_more\Plugin\rest\resource;

use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ResourceResponse;
use Psr\Log\LoggerInterface;
use Drupal\Core\Session\AccountProxyInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
/**
 * Provides a resource to get view modes by entity and bundle.
 * @RestResource(
 *   id = "custom_get_news_events_view_more",
 *   label = @Translation("Custom Get news events view more"),
 *   uri_paths = {
 *     "canonical" = "news/events/view/more",
 *   }
 * )
 */
class NewsEventsViewMore extends ResourceBase {
  /**
   * Responds to entity GET requests.
   * @return \Drupal\rest\ResourceResponse
   */
    public function get() {
     $nids =  \Drupal::request()->query->get('nid');

      $nodes =  \Drupal\node\Entity\Node::load($nids);
      $pid = $nodes->field_news_events_view_more_para;
      
      foreach($pid as $key => $para){
        $paragraph[$key] = $para->entity;
        $field_img[$key] = $paragraph[$key]->field_image;
        $paragraph_field[$key] = [
        $field_description[$key] = $paragraph[$key]->field_description->value, 
        $imageUri[$key] =  $field_img[$key]->entity->uri->value,
        ]; 
    }
    return new ResourceResponse($paragraph_field);
  }  
  }
    
  