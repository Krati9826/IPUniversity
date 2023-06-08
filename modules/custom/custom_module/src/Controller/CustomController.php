<?php
namespace Drupal\custom_module\Controller;
use Drupal\block\Entity\Block;
use Symfony\Component\HttpFoundation\RequestStack;   
use Drupal\paragraphs\Entity\Paragraph;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\file\Entity\File;

class CustomController{
           function custom(){
            $nids = \Drupal::entityQuery('node')->condition('type','alumni_speak')->execute();
            // dump($nids);       
            //$nid =  \Drupal::request()->query->get('nid');
             
             $nodes =  \Drupal\node\Entity\Node::load($nids[20]);
            //  dump($nodes);       

             $pid = $nodes->field_alumni_speak_paragraph;
             foreach($pid as $key=> $para){
               $paragraph[$key] = $para->entity;

               $field_img[$key] = $paragraph[$key]->field_image;
                          

               $paragraph_field[$key] =[ 
                 $field_name[$key] = $paragraph[$key]->field_name->value,
                 $field_profession[$key] = $paragraph[$key]->field_profession->value,
                 $field_about_person[$key] = $paragraph[$key]->field_about_person_->value,  
                 $imageUri[$key] =  $field_img[$key]->entity->uri->value,
                 dump($imageUri),
               ]; 
             
             }

     return[];
    }
   }
  
    
