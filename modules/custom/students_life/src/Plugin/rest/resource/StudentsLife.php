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
       $nids = \Drupal::entityQuery('node')->condition('type','student_life')->execute();
       
       //$nid =  \Drupal::request()->query->get('nid');
       $nodes =  \Drupal\node\Entity\Node::load($nid);
       $pid = $nodes->field_student_life_paragraph;
     

      foreach($pid as $key => $para){
        $paragraph[$key] = $para->entity;
        
      
        $field_img[$key] = $paragraph[$key]->field_image;
        //dump($field_img[$key]);

        $paragraph_field[$key] = [

        $imageUri[$key] =  $field_img[$key]->entity->uri->value,
        ]; 
      }
      return new ResourceResponse($paragraph_field);
    }
      
  }
    
  