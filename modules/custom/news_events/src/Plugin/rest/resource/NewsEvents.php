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
class NewsEvents extends ResourceBase {
  /**
   * Responds to entity GET requests.
   * @return \Drupal\rest\ResourceResponse
   */
    public function get() {
      //$nids = \Drupal::entityQuery('node')->condition('type','news_events_')->execute();
      $nid =  \Drupal::request()->query->get('nid');
      $nids = explode(',', $nid);
      foreach($nids as $key => $value)
      {   
        $nodes[$key] =  \Drupal\node\Entity\Node::load($value);
      }

      foreach ($nodes as $key=>$values) {        
        $arrayValue[$key] = [
          $description[$key] = $values->field_description->value,
          $field_image[$key] = $values->field_image->entity->uri->value,
          $field_overview[$key] = $values->field_overview->value,
          $field_about_school_[$key] = $values->field_about_school_->value,
        ];
        }
     
      return new ResourceResponse($arrayValue);
    }
      
  }
    
  