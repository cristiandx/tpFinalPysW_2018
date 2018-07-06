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
 * Novedad controller.
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
        $novedades = $em->getRepository('AdministracionBundle:Novedad')->findAll();
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
        'novedades' => $serializer->serialize($novedades, 'json'),
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
         //confecciono una entidad empresa para asignar a mensaje
         $usuarioArray= $request->request->get('usuario');
         $idusuario = $usuarioArray['id'];
         $em = $this->getDoctrine()->getManager();
         $usuario = $em->getRepository("AdministracionBundle:Usuario")->find($idusuario);
         $novedad->setUsuario($usuario);

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
        $novedad = $em->getRepository('AdministracionBundle:Novedad')->find($id);
        //confecciono una entidad empresa para asignar a mensaje
        $usuarioArray= $request->request->get('usuario');
        $idusuario = $usuarioArray['id'];
        $em = $this->getDoctrine()->getManager();
        $usuario = $em->getRepository("AdministracionBundle:Usuario")->find($idusuario);
        $novedad->setUsuario($usuario);
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
        $novedad = $em->getRepository('AdministracionBundle:Novedad')->find($id);

        if (!$novedad){
            throw $this->createNotFoundException('id incorrecta');
        }

        $em->remove($novedad);
        $em->flush();
        $result['status'] = 'ok';
        return new Response(json_encode($result), 200);
    }

    
    

}