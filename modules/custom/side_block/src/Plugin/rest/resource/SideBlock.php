<?php
 namespace Drupal\side_block\Plugin\rest\resource;

use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ResourceResponse;
use Psr\Log\LoggerInterface;
use Drupal\Core\Session\AccountProxyInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Drupal\Core\Entity\EntityTypeManagerInterface;
 
/**
 * Provides a resource to get view modes by entity and bundle.
 * @RestResource(
 *   id = "custom_get_side_block",
 *   label = @Translation("Custom Get side block"),
 *   uri_paths = {
 *     "canonical" = "/side/block",
 *   }
 * )
 */
class SideBlock extends ResourceBase {
  /**
   * Responds to entity GET requests.
   * @return \Drupal\rest\ResourceResponse
   */
    public function get() {
      //$response = ['message' => 'Hello, this is a rest service'];

      $block_id = 'sideblock'; 
            $block = \Drupal\block\Entity\Block::load($block_id);
            $uuid = $block->getPlugin()->getDerivativeId();

            $block_content = \Drupal::service('entity.repository')->loadEntityByUuid('block_content', $uuid);
      
            $entity = $block_content->field_side_block;
      
            foreach($entity as $key => $para){
             $value = $para->entity;
             $result[$key]=[
              $field_title = $value->field_title->value,
              $field_description = $value->field_description->value,
             ];
            
           }
    return new ResourceResponse($result);

   }

  }
    

  
    
  