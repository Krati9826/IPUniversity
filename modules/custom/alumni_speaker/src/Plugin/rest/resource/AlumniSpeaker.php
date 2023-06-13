<?php
 namespace Drupal\alumni_speaker\Plugin\rest\resource;

use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ResourceResponse;
use Psr\Log\LoggerInterface;
use Drupal\Core\Session\AccountProxyInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
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
     
     $nid =  \Drupal::request()->query->get('nid');
      
      $nodes =  \Drupal\node\Entity\Node::load($nid);
      $pid = $nodes->field_alumni_speak_paragraph;
      foreach($pid as $key=> $para){
        $paragraph[$key] = $para->entity;
        $field_img[$key] = $paragraph[$key]->field_image;
            
        $paragraph_field[$key] =[ 
          $field_name[$key] = $paragraph[$key]->field_name->value,
          $field_profession[$key] = $paragraph[$key]->field_profession->value,
          $field_about_person[$key] = strip_tags($paragraph[$key]->field_about_person_->value),
          $imageUri[$key] =  $field_img[$key]->entity->uri->value,
     
        ]; 
      
      }
      return new ResourceResponse($paragraph_field);
    }
      
  }
    
  