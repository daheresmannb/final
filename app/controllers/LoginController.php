<?php
use \Phalcon\Http\Response;
use \Phalcon\Paginator\Adapter\Model as Paginator;

class LoginController extends \Phalcon\Mvc\Controller {
    public function LoginAction() {
        $response = new \Phalcon\Http\Response();
        $sesion = $this->getDI()->getShared("session");
        if ($sesion->has("us_id")) {
            return $this->response->redirect($_SERVER['SERVER_NAME'].'/alumnos');
        }

        if ($this->request->isPost()) {
            if (!empty($_POST['usuario'])) {
                $us = $_POST['usuario'];
            } else {
                $us = null;
            }

            $usuario = Usuarios::Encontrar(  
                $us
            );
            if ($usuario && !empty($_POST['contraseña'])) {
                if ($this->security->checkHash($_POST['contraseña'], $usuario[0]->password)) {
                    $respuesta['exito']     = true;
                    $respuesta['respuesta'] = $usuario;

                    $this->view->postId = $postId;
                    $sesion->set("us_id", $usuario->id);
                    $sesion->set("us_nombre", $usuario->nombre);
                    $sesion->set("us_apellido", $usuario->apellido);     

                    //$response->redirect('alumnos');                
                } else {
                    $respuesta['exito']     = false;
                    $respuesta['respuesta'] = "Contraseña incorrecta";
                }
            } else {
                $respuesta['exito']     = false;
                $respuesta['respuesta'] = "Usuario no encontrado";
            } 
        } else {
                $respuesta['exito']     = false;
                $respuesta['respuesta'] = "Metodo no admitido"; 
        }
        $response->setHeader('Access-Control-Allow-Origin', 'POST');
        return $response->setContent(
            json_encode(
                $respuesta
            )
        );
    }
}