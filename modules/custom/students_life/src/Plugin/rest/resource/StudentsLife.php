<?php
 namespace Drupal\students_life\Plugin\rest\resource;

use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ResourceResponse;
use Psr\Log\LoggerInterface;
use Drupal\Core\Session\AccountProxyInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
/**
 * Provides a resource to get view modes by entity and bundle.
 * @RestResource(
 *   id = "custom_get_students_life",
 *   label = @Translation("Custom Get students_life"),
 *   uri_paths = {
 *     "canonical" = "/students/life",
 *   }
 * )
 */
class StudentsLife extends ResourceBase {
  /**
   * Responds to entity GET requests.
   * @return \Drupal\rest\ResourceResponse
   */
    public function get() {
       //$nids = \Drupal::entityQuery('node')->condition('type','student_life')->execute();
       
       $storage = \Drupal::entityTypeManager()->getStorage('node');
       // Define the query to retrieve nodes.
       $query = $storage->getQuery()
         ->condition('type', 'student_life') // Optionally, filter by content type.
         ->condition('status', 1); // Optionally, filter by node status (1 for published).
         
         $entity_ids = $query->execute();
         $nodes = $storage->loadMultiple($entity_ids);
     

      foreach($nodes as $key => $value){
        
        $array_field[$key] = [

        $imageUri[$key] =  $value->field_image->entity->uri->url,
        ]; 
      }
      return new ResourceResponse($array_field);
    }
      
  }
    
  