<?php
 namespace Drupal\top_recruiters\Plugin\rest\resource;

use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ResourceResponse;
use Psr\Log\LoggerInterface;
use Drupal\Core\Session\AccountProxyInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Drupal\file\Entity\File;

/**
 * Provides a resource to get view modes by entity and bundle.
 * @RestResource(
 *   id = "custom_get_top_recruiters",
 *   label = @Translation("Custom Get top recruiters"),
 *   uri_paths = {
 *     "canonical" = "/top/recruiters",
 *   }
 * )
 */
class TopRecruiters extends ResourceBase {
  /**
   * Responds to entity GET requests.
   * @return \Drupal\rest\ResourceResponse
   */
    public function get() {
     
      $nid =  \Drupal::request()->query->get('nid');
      $nodes =  \Drupal\node\Entity\Node::load($nid);

       $pid = $nodes->field_our_top_recruiters;
        // die($paragraph);
       foreach($pid as $key => $para)
       {
        // if($para->target_id == 2)
        // {
        //   print_r('hello');
        // }
         $paragraph = $para->target_id;
         $file = File::load($paragraph);

         $link [$key]= $file->uri->value;
       }
      return new ResourceResponse($link);
    }
      
  }
    
  