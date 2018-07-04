<?php

namespace AdministracionBundle\Controller;

use AdministracionBundle\Entity\Local;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/*AGREGADOs*/
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
/*AGREGADOs*/

/**
 * Local controller.
 *
 * @Route("local")
 */
class LocalController extends Controller
{
    /**
     * Lists all local entities.
     *
     * @Route("/", name="local_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $locales = $em->getRepository('AdministracionBundle:Local')->findAll();
        $response = new Response();
        $encoders = array(new JsonEncoder());

        $normalizers = array((new ObjectNormalizer())->setIgnoredAttributes(
            [
                "__initializer__", 
                "__cloner__",
                "__isInitialized__"
            ]));

        $serializer = new Serializer($normalizers, $encoders);
        $response->setContent(json_encode(array(
        'locales' => $serializer->serialize($locales, 'json'),
        )));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * Creates a new local entity.
     *
     * @Route("/new", name="local_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $request->request->replace($data);
        $local = new Local();
        $local->setSuperficie($request->request->get('superficie'));
        $local->setHabilitado($request->request->get('habilitado'));
        $local->setCostomes($request->request->get('costomes'));
        $local->setPathimagen($request->request->get('pathimagen'));
        $local->setAlquilado($request->request->get('alquilado'));

        
        $em = $this->getDoctrine()->getManager();
        
        $em->persist($local);
        $em->flush();
        
        $result['status'] = 'ok';
        return new Response(json_encode($result), 200);
    }

   

    /**
     * Displays a form to edit an existing local entity.
     *
     * @Route("/{id}/edit", name="local_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction($id,Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $request->request->replace($data);

        $em = $this->getDoctrine()->getManager();
        $local = $em->getRepository('AdministracionBundle:Local')->find($id);
        $local->setSuperficie($request->request->get('superficie'));
        $local->setHabilitado($request->request->get('habilitado'));
        $local->setCostomes($request->request->get('costomes'));
        $local->setPathimagen($request->request->get('pathimagen'));
        $local->setAlquilado($request->request->get('alquilado'));
        
        $em = $this->getDoctrine()->getManager();
        
        $em->persist($local);
        $em->flush();
        
        $result['status'] = 'ok';
        return new Response(json_encode($result), 200);
    }

    //anotacion (define lo q hace el metodo de  abajo)
    /**
     * Deletes a local entity.
     *
     * @Route("/{id}", name="local_delete")
     * @Method("DELETE")
     */

    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $local = $em->getRepository('AdministracionBundle:Local')->find($id);

        if (!$local){
            throw $this->createNotFoundException('id incorrecta');
        }

        $em->remove($local);
        $em->flush();
        $result['status'] = 'ok';
        return new Response(json_encode($result), 200);
    }
}