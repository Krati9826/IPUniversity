<?php

namespace Drupal\university_information\Plugin\rest\resource;

use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ResourceResponse;
use Psr\Log\LoggerInterface;
use Drupal\Core\Session\AccountProxyInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\taxonomy\TermStorageInterface;
use Drupal\file\FileUrlGeneratorInterface;
// use Drupal\Core\Path\AliasManagerInterface;
/**
 * Provides a resource to get view modes by entity and bundle.
 * @RestResource(
 *   id = "university_information",
 *   label = @Translation("University Information"),
 *   uri_paths = {
 *     "canonical" = "/university-information"
 *   }
 * )
 */
class UniversityInformation extends ResourceBase {
  /**
   * A current user instance which is logged in the session.
   * @var \Drupal\Core\Session\AccountProxyInterface
   */
  protected $loggedUser;
  protected $entityTypeManager;
  protected $termStorage;
//   protected $fileUrlGenerator;
//   protected $aliasManager;
  
  /**
   * Constructs a Drupal\rest\Plugin\ResourceBase object.
   *
   * @param array $config
   *   A configuration array which contains the information about the plugin instance.
   * @param string $module_id
   *   The module_id for the plugin instance.
   * @param mixed $module_definition
   *   The plugin implementation definition.
   * @param array $serializer_formats
   *   The available serialization formats.
   * @param \Psr\Log\LoggerInterface $logger
   *   A logger instance.
   * @param \Drupal\Core\Session\AccountProxyInterface $current_user
   *   A currently logged user instance.
   */
  public function __construct(
    array $config,
    $module_id,
    $module_definition,
    array $serializer_formats,
    LoggerInterface $logger,
    AccountProxyInterface $current_user, EntityTypeManagerInterface $entityTypeManager,TermStorageInterface $term_storage) {
    parent::__construct($config, $module_id, $module_definition, $serializer_formats, $logger);

    $this->loggedUser = $current_user;
    $this->entityTypeManager = $entityTypeManager;
    $this->termStorage = $term_storage;
    // $this->fileUrlGenerator = $file_url_generator;
    // // $this->aliasManager = $alias_manager;
    
  }
  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $config, $module_id, $module_definition) {
    return new static(
      $config,
      $module_id,
      $module_definition,
      $container->getParameter('serializer.formats'),
      $container->get('logger.factory')->get('sample_rest_resource'),
      $container->get('current_user'),
      $container->get('entity_type.manager'),
      $container->get('entity_type.manager')->getStorage('taxonomy_term'),
    //   $container->get('file_url_generator')
    //   $container->get('path.alias_manager')
    );
  }
  /**
   * Responds to GET request.
   * Returns a list of taxonomy terms.
   * @throws \Symfony\Component\HttpKernel\Exception\HttpException
   * Throws exception expected.
   */
  public function get() {
    // Implementing our custom REST Resource here.
    // Use currently logged user after passing authentication and validating the access of term list.
    if (!$this->loggedUser->hasPermission('access content')) {
      throw new AccessDeniedHttpException();
    }	
	
    $vid = 'university_informat';
    $terms =  \Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadByProperties(['vid' => $vid]);
    
   $term_result = [];
   foreach ($terms as $key=>$term) {
    
      $term_result[$key] =   [ 
      $name = $term->name->value,
    //   //$image= $term->field_image->entity->uri->url,
    //   $image_url = $term->fileUrlGenerator->generateAbsoluteString($term->field_image->entity->uri->url),
      $path = $term->path->alias,
    ];
   }

    return new ResourceResponse($term_result);
   
  }
}
  



