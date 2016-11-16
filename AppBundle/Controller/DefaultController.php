<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

// Serializer Component : See http://symfony.com/doc/current/components/serializer.html
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Koen Vinken <vinkenkoen@gmail.com>
 */
class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->render('AppBundle:Default:index.html.twig');
    }

    public function randomAction($limit)
    {
        return new JsonResponse(array(
            'number' => rand(0, $limit)
        ));
    }

    /**
     * @Route("/json/example")
     */
    public function jsonAction()
    {

        // Preparing The Serializer
        /*$encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());
        $serializer = new Serializer($normalizers, $encoders);*/

        // Getting the Serializer Service (must be activated in config.yml)
        // See : http://symfony.com/doc/current/components/serializer.html
        $serializer = $this->get('serializer');

        // ===== PARAMETERS =====
        // Preparing Data
        $data_test = array('cle_test' => 'valeur_test');
        $data_test2 = array('cle_test2' => 'valeur_test2');

        $testNumber = 2; // Régler ce paramètre pour choisir la méthode souhaitée
        // =======================
        
        switch($testNumber){
          case 1:
              /* TEST 1 (OK) : Avec la classe JsonResponse */
              // Needs : use Symfony\Component\HttpFoundation\JsonResponse;
              $response = new JsonResponse();
              $response->setData($data_test); // when the data is an array

          break;

          case 2:
              /* TEST 2 (OK) : Avec la classe Response */
              // Serializing the Data
              $jsonContent = $serializer->serialize($data_test2, 'json');
              // Prepare the Response
              $response = new Response();
              $response->setContent($jsonContent);
              // set a HTTP response header
              $response->headers->set('Content-Type', 'application/json');
          break;

          case 3:
              /* TEST 3 (OK) : Avec la classe Response et un OBJET */
              // TODO : Ajouter la classe objet et l'utiliser...
          break;
        }

        return $response;

    }
}
