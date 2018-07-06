<?php

namespace AdministracionBundle\Controller;

use AdministracionBundle\Entity\Alquiler;
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
 * Alquiler controller.
 *
 * @Route("alquiler")
 */
class AlquilerController extends Controller
{
    /**
     * Lists all alquiler entities.
     *
     * @Route("/", name="alquiler_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $alquileres = $em->getRepository('AdministracionBundle:Alquiler')->findAll();
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
        'alquileres' => $serializer->serialize($alquileres, 'json'),
        )));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * Creates a new alquiler entity.
     *
     * @Route("/new", name="alquiler_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $request->request->replace($data);
        
        $alquiler = new Alquiler();
        //confecciono una entidad empresa para asignar a mensaje
        $propietarioArray= $request->request->get('propietario');
        $idPropietario = $propietarioArray['id'];
        $em = $this->getDoctrine()->getManager();
        $propietario = $em->getRepository("AdministracionBundle:Propietario")->find($idPropietario);
        $alquiler->setPropietario($propietario);
        
         //confecciono una entidad empresa para asignar a mensaje
         $localArray= $request->request->get('local');
         $idLocal = $localArray['id'];
         $em = $this->getDoctrine()->getManager();
         $local = $em->getRepository("AdministracionBundle:Local")->find($idLocal);
         $alquiler->setLocal($local);

        $alquiler->setPlazomes($request->request->get('plazomes'));
        $alquiler->setCostoalquiler($request->request->get('costoalquiler'));
        
        $fecha = new \DateTime($request->request->get('fecha'));
        $alquiler->setFechaalquiler($fecha);
                
        $em->persist($alquiler);
        $em->flush();
        
        $result['status'] = 'ok';
        return new Response(json_encode($result), 200);
    }

   
  

    /**
     * Displays a form to edit an existing alquiler entity.
     *
     * @Route("/{id}/edit", name="alquiler_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction($id ,Request $request)
    {

        $data = json_decode($request->getContent(), true);
        $request->request->replace($data);
        $em = $this->getDoctrine()->getManager();
        $alquiler = $em->getRepository("AdministracionBundle:Alquiler")->find($id);
        //confecciono una entidad empresa para asignar a mensaje
        $propietarioArray= $request->request->get('propietario');
        $idPropietario = $propietarioArray['id'];
        $propietario = $em->getRepository("AdministracionBundle:Propietario")->find($idPropietario);
        $alquiler->setPropietario($propietario);
        
         //confecciono una entidad empresa para asignar a mensaje
         $localArray= $request->request->get('local');
         $idLocal = $localArray['id'];
         $em = $this->getDoctrine()->getManager();
         $local = $em->getRepository("AdministracionBundle:Local")->find($idLocal);
         $alquiler->setLocal($local);

        $alquiler->setPlazomes($request->request->get('plazomes'));
        $alquiler->setCostoalquiler($request->request->get('costoalquiler'));
        
        $fecha = new \DateTime($request->request->get('fecha'));
        $alquiler->setFechaalquiler($fecha);
                
        $em->persist($alquiler);
        $em->flush();
        
        $result['status'] = 'ok';
        return new Response(json_encode($result), 200);
    }

    /**
     * Deletes a alquiler entity.
     *
     * @Route("/{id}", name="alquiler_delete")
     * @Method("DELETE")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $alquiler = $em->getRepository('AdministracionBundle:Alquiler')->find($id);

        if (!$alquiler){
            throw $this->createNotFoundException('id incorrecta');
        }

        $em->remove($alquiler);
        $em->flush();
        $result['status'] = 'ok';
        return new Response(json_encode($result), 200);
    }

   
}
