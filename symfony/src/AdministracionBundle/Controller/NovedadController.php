<?php

namespace AdministracionBundle\Controller;

use AdministracionBundle\Entity\Novedad;
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
 * novedad controller.
 *
 * @Route("novedad")
 */
class NovedadController extends Controller
{
    /**
     * Lists all novedad entities.
     *
     * @Route("/", name="novedad_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $novedads = $em->getRepository('AdministracionBundle:novedad')->findAll();
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
        'novedads' => $serializer->serialize($novedads, 'json'),
        )));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * Creates a new novedad entity.
     *
     * @Route("/new", name="novedad_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $request->request->replace($data);
        //cMBIAR
        $novedad = new Novedad();
        $novedad->setUsuario($request->request->get('usuario'));
        $novedad->setTexto($request->request->get('texto'));
        $novedad->setEstado($request->request->get('estado'));
       

        
        $em = $this->getDoctrine()->getManager();
        
        $em->persist($novedad);
        $em->flush();
        
        $result['status'] = 'ok';
        return new Response(json_encode($result), 200);
    }

   

    /**
     * Displays a form to edit an existing novedad entity.
     *
     * @Route("/{id}/edit", name="novedad_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction($id,Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $request->request->replace($data);

        $em = $this->getDoctrine()->getManager();
        $novedad = $em->getRepository('AdministracionBundle:novedad')->find($id);
//cambiar
        $novedad->setUsuario($request->request->get('usuario'));
        $novedad->setTexto($request->request->get('texto'));
        $novedad->setEstado($request->request->get('estado'));
        
        $em = $this->getDoctrine()->getManager();
        
        $em->persist($novedad);
        $em->flush();
        
        $result['status'] = 'ok';
        return new Response(json_encode($result), 200);
    }

    //anotacion (define lo q hace el metodo de  abajo)
    /**
     * Deletes a novedad entity.
     *
     * @Route("/{id}", name="novedad_delete")
     * @Method("DELETE")
     */

    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $novedad = $em->getRepository('AdministracionBundle:novedad')->find($id);

        if (!$novedad){
            throw $this->createNotFoundException('id incorrecta');
        }

        $em->remove($novedad);
        $em->flush();
        $result['status'] = 'ok';
        return new Response(json_encode($result), 200);
    }

    
    

}