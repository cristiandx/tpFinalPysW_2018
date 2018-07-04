<?php

namespace AdministracionBundle\Controller;

use AdministracionBundle\Entity\Usuario;
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
 * Usuario controller.
 *
 * @Route("usuario")
 */
class UsuarioController extends Controller
{
    /**
     * Lists all usuario entities.
     *
     * @Route("/", name="usuario_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $usuarios = $em->getRepository('AdministracionBundle:Usuario')->findAll();
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
        'usuarios' => $serializer->serialize($usuarios, 'json'),
        )));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * Creates a new usuario entity.
     *
     * @Route("/new", name="usuario_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $request->request->replace($data);
        
        $usuario = new Usuario();
        $usuario->setEmail($request->request->get('email'));
        $usuario->setUsuario($request->request->get('usuario'));
        $usuario->setPassword($request->request->get('password'));
        $usuario->setActivo($request->request->get('activo'));
        $usuario->setPerfil($request->request->get('perfil'));
        
        $em = $this->getDoctrine()->getManager();
        
        $em->persist($usuario);
        $em->flush();
        
        $result['status'] = 'ok';
        return new Response(json_encode($result), 200);
    }

   

    /**
     * Displays a form to edit an existing usuario entity.
     *
     * @Route("/{id}/edit", name="usuario_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction($id,Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $request->request->replace($data);

        $em = $this->getDoctrine()->getManager();
        $usuario = $em->getRepository('AdministracionBundle:Usuario')->find($id);

        $usuario->setEmail($request->request->get('email'));
        $usuario->setUsuario($request->request->get('usuario'));
        $usuario->setPassword($request->request->get('password'));
        $usuario->setActivo($request->request->get('activo'));
        $usuario->setPerfil($request->request->get('perfil'));
        
        $em = $this->getDoctrine()->getManager();
        
        $em->persist($usuario);
        $em->flush();
        
        $result['status'] = 'ok';
        return new Response(json_encode($result), 200);
    }

    /**
     * Deletes a usuario entity.
     *
     * @Route("/{id}", name="usuario_delete")
     * @Method("DELETE")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $usuario = $em->getRepository('AdministracionBundle:Usuario')->find($id);

        if (!$usuario){
            throw $this->createNotFoundException('id incorrecta');
        }

        $em->remove($usuario);
        $em->flush();
        $result['status'] = 'ok';
        return new Response(json_encode($result), 200);
    }

    /**
     * Validate user.
     *
     * @Route("/authenticate", name="usuario_authenticate")
     * @Method({"GET", "POST"})
     */
    public function authenticateAction(Request $request)
    {

        $data = json_decode($request->getContent(), true);
        $request->request->replace($data);
        //creamos un usuario
        $username = $request->request->get('usuario');
        $userpassword = $request->request->get('password');

        $criteria = array('usuario' => $username, 'password' => $userpassword);
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository("AdministracionBundle:Usuario")->findBy($criteria);
		
        if($user != null){
            $resultUsuario = $user[0];
        }else{
            //retorno un usuario sin datos
            $resultUsuario = new Usuario();
        }
        //genero la respuesta hacia el cliente
        $response = new Response();
        $encoders = array(new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());
        $serializer = new Serializer($normalizers, $encoders);
        $response->setContent(json_encode(array(
        'usuario' => $serializer->serialize($resultUsuario, 'json'),
        )));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

}
