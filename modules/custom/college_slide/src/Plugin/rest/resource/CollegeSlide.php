<?php
 namespace Drupal\college_slide\Plugin\rest\resource;

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
 *   id = "college_slide",
 *   label = @Translation("College Slide"),
 *   uri_paths = {
 *     "canonical" = "/college-slide",
 *   }
 * )
 */
class CollegeSlide extends ResourceBase {
  /**
   * Responds to entity GET requests.
   * @return \Drupal\rest\ResourceResponse
   */
    public function get() {

    $storage = \Drupal::entityTypeManager()->getStorage('node');
    $query = $storage->getQuery()
      ->condition('type', 'camp') // Optionally, filter by content type.
      ->condition('status', 1);
    $entity_ids = $query->execute();
    $nodes = $storage->loadMultiple($entity_ids);
    
    $arrayValue = [];
    
    foreach ($nodes as $key => $node) {
    // $image = file_create_url($node->field_imagevalue->entity->uri->value);  
    $arrayValue[$key] = [
        $title = $node->title->value,
        $image = $node->field_imagevalue->entity->uri->url,
      ];
    }
      return new ResourceResponse($arrayValue);
    }
      
  }