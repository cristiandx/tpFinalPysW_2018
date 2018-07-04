<?php

namespace AdministracionBundle\Controller;

use AdministracionBundle\Entity\Propietario;
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
 * Propietario controller.
 *
 * @Route("propietario")
 */
class PropietarioController extends Controller
{
    /**
     * Lists all propietario entities.
     *
     * @Route("/", name="propietario_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $propietarios = $em->getRepository('AdministracionBundle:Propietario')->findAll();
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
        'propietarios' => $serializer->serialize($propietarios, 'json'),
        )));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * Creates a new propietario entity.
     *
     * @Route("/new", name="propietario_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $request->request->replace($data);
        
        $propietario = new Propietario();
        $propietario->setApellido($request->request->get('apellido'));
        $propietario->setNombres($request->request->get('nombres'));
        $propietario->setDni($request->request->get('dni'));
        $propietario->setEmail($request->request->get('email'));
        $propietario->setTelefono($request->request->get('telefono'));
        
        $em = $this->getDoctrine()->getManager();
        
        $em->persist($propietario);
        $em->flush();
        
        $result['status'] = 'ok';
        return new Response(json_encode($result), 200);
    }

    /**
     * Displays a form to edit an existing propietario entity.
     *
     * @Route("/{id}/edit", name="propietario_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction($id,Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $request->request->replace($data);

        $em = $this->getDoctrine()->getManager();
        $propietario = $em->getRepository('AdministracionBundle:Propietario')->find($id);

        $propietario->setApellido($request->request->get('apellido'));
        $propietario->setNombres($request->request->get('nombres'));
        $propietario->setDni($request->request->get('dni'));
        $propietario->setEmail($request->request->get('email'));
        $propietario->setTelefono($request->request->get('telefono'));
        
        $em = $this->getDoctrine()->getManager();
        
        $em->persist($propietario);
        $em->flush();
        
        $result['status'] = 'ok';
        return new Response(json_encode($result), 200);
    }

    //anotacion (define lo q hace el metodo de  abajo)
    /**
     * Deletes a propietario entity.
     *
     * @Route("/{id}", name="propietario_delete")
     * @Method("DELETE")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $propietario = $em->getRepository('AdministracionBundle:Propietario')->find($id);

        if (!$propietario){
            throw $this->createNotFoundException('id incorrecta');
        }

        $em->remove($propietario);
        $em->flush();
        $result['status'] = 'ok';
        return new Response(json_encode($result), 200);
    }

   
}
