<?php
 namespace Drupal\alumni_speaker\Plugin\rest\resource;

use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ResourceResponse;
use Psr\Log\LoggerInterface;
use Drupal\node\Entity\Node;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Session\AccountProxyInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Drupal\file\Entity\File;


/**
 * Provides a resource to get view modes by entity and bundle.
 * @RestResource(
 *   id = "custom_get_alumni_speaker",
 *   label = @Translation("Custom Get alumni speaker"),
 *   uri_paths = {
 *     "canonical" = "/alumni/speaker",
 *   }
 * )
 */
class AlumniSpeaker extends ResourceBase {
  /**
   * Responds to entity GET requests.
   * @return \Drupal\rest\ResourceResponse
   */
    public function get() {

      $storage = \Drupal::entityTypeManager()->getStorage('node');
      // Define the query to retrieve nodes.
      $query = $storage->getQuery()
        ->condition('type', 'alumni_speak') // Optionally, filter by content type.
        ->condition('status', 1); // Optionally, filter by node status (1 for published).
     
        $entity_ids = $query->execute();
        $nodes = $storage->loadMultiple($entity_ids);
        foreach($nodes as $key => $value)
        {
          $imagePaths[$key]=[
          $body = $value->field_body->value,
          ];
        }
  return new ResourceResponse($imagePaths);

}
}

 