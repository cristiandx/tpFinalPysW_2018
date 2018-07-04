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
        $propietario = $em->getRepository("AdministracionBundle:Alquiler")->find($idPropietario);
        $alquiler->setPropietario($propietario);
        
        $alquiler->set($request->request->get('desde'));
        $mensaje->setHasta($request->request->get('hasta'));
        $mensaje->setTexto($request->request->get('texto'));
        $fecha = new \DateTime($request->request->get('fecha'));
        $mensaje->setFecha($fecha);
        
        //confecciono una entidad empresa para asignar a mensaje
        $empresaArray= $request->request->get('empresa');
        $idEmpresa = $empresaArray['id'];
        $em = $this->getDoctrine()->getManager();
        $empresa = $em->getRepository("MensajeBundle:Empresa")->find($idEmpresa);
        $mensaje->setEmpresa($empresa);
        
        $em->persist($mensaje);
        $em->flush();
        
        $result['status'] = 'ok';
        return new Response(json_encode($result), 200);
    }

    /**
     * Finds and displays a alquiler entity.
     *
     * @Route("/{id}", name="alquiler_show")
     * @Method("GET")
     */
    public function showAction(Alquiler $alquiler)
    {
        $deleteForm = $this->createDeleteForm($alquiler);

        return $this->render('alquiler/show.html.twig', array(
            'alquiler' => $alquiler,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing alquiler entity.
     *
     * @Route("/{id}/edit", name="alquiler_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Alquiler $alquiler)
    {
        $deleteForm = $this->createDeleteForm($alquiler);
        $editForm = $this->createForm('AdministracionBundle\Form\AlquilerType', $alquiler);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('alquiler_edit', array('id' => $alquiler->getId()));
        }

        return $this->render('alquiler/edit.html.twig', array(
            'alquiler' => $alquiler,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a alquiler entity.
     *
     * @Route("/{id}", name="alquiler_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Alquiler $alquiler)
    {
        $form = $this->createDeleteForm($alquiler);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($alquiler);
            $em->flush();
        }

        return $this->redirectToRoute('alquiler_index');
    }

    /**
     * Creates a form to delete a alquiler entity.
     *
     * @param Alquiler $alquiler The alquiler entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Alquiler $alquiler)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('alquiler_delete', array('id' => $alquiler->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
