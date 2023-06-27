<?php
 namespace Drupal\news_events\Plugin\rest\resource;

use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ResourceResponse;
use Psr\Log\LoggerInterface;
use Drupal\Core\Session\AccountProxyInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Drupal\node\Entity\Node;
use Drupal\Core\Entity\EntityStorageInterface;
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
     
      $storage = \Drupal::entityTypeManager()->getStorage('node');
      
     $query = $storage->getQuery()
    ->condition('type', 'news_events_') // Optionally, filter by content type.
    ->condition('status', 1) // Optionally, filter by node status (1 for published).
    ->range(0, 10); // Optionally, limit the number of nodes retrieved.
  
  // Execute the query and retrieve the node IDs.
  $entity_ids = $query->execute();
  
  // Load the nodes using the retrieved IDs.
  $nodes = $storage->loadMultiple($entity_ids);
     
      $arrayValue = [];
      foreach ($nodes as $key=>$values) {        
        $arrayValue[$key] = [
          $description[$key] = $values->field_description->value,
          
        ];
        }
     
      return new ResourceResponse($arrayValue);
    }
      
  }
    
  