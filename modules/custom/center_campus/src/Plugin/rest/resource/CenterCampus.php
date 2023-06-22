<?php
 namespace Drupal\center_campus\Plugin\rest\resource;

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
 *   id = "center_campus_discription",
 *   label = @Translation("Custom Get Center Campus"),
 *   uri_paths = {
 *     "canonical" = "/center-campus",
 *   }
 * )
 */
class CenterCampus extends ResourceBase {
  /**
   * Responds to entity GET requests.   
   * @return \Drupal\rest\ResourceResponse
   */
    public function get() {
        $entityTypeManager = \Drupal::entityTypeManager();
        $data = [];
        $nodeStorage = $entityTypeManager->getStorage('node');
    
        $query_string = \Drupal::request()->query->get('nid') ; 
        $nids = explode(',',$query_string);
        $nodes = $nodeStorage->loadMultiple($nids);
        
        foreach ($nodes as $key =>$node) {

           //main title
          $data[$node->nid->value]['main_title'] = $node->field_main_title->value;


           // video
           $videos = $node->get('field_main_video')->referencedEntities();
           foreach ($videos as $video) {
               $data[$node->nid->value]['video_file'] = $video->field_media_video_file->entity->uri->value;
            }    
           


           //images5
          $images = $node->get('field_images5')->referencedEntities();
            // dump($images);die;
            // Iterate through the referenced entities.
           foreach ($images as $image) {
              $data[$node->nid->value]['image_file'][] = $image->field_upper_img->entity->uri->value;
              // dump($data[$node->nid->value]['image_file']);

            }
 

            // about
          $about = $node->get('field_about_clg')->referencedEntities();
          // dump($about);die;
            foreach ($about as $referencedEntity) {
                $data[$node->nid->value]['about_title'][] = $referencedEntity->field_about_title->value;
            }
            foreach ($about as $referencedEntity) {
              $data[$node->nid->value]['about_subtitle'][] = $referencedEntity->field_about_subti->value;
            }

          
            //courses
          $courses = $node->get('field_courses')->referencedEntities();
            //  dump($courses);die;
            // Iterate through the referenced entities.
            foreach ($courses as $course) {
              $data[$node->nid->value]['courses_logo'][] = $course->field_courses_logo->entity->uri->url;
            }  
            foreach ($courses as $course) {
              $data[$node->nid->value]['courses_title'][] = $course->field_course_title->value;
            }
            foreach ($courses as $course) {  
              $data[$node->nid->value]['courses_subtitle'][] = $course->field_course_subtitle->value;
            }

          
            //main gallery
          $imagess = $node->get('field_mainimg_gall')->referencedEntities();
            // dump($imagess);die;
            // Iterate through the referenced entities.
            foreach ($imagess as $img) {
              $data[$node->nid->value]['image9_file'][] = $img->field_nine_img->entity->uri->url;
              //dump($data[$node->nid->value]['image_file']);

            } 
     
           

           
            
            
           
        // $data[$node->nid->value]['feild_courses'] = $node->field_courses->value;
       // $data[$node->nid->value] = $node->field_images5->entity->field_upper_img->url;
      }
      return new ResourceResponse($data);
    }
      
  }    
