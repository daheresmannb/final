<?php
use \Phalcon\Http\Response;
use \Phalcon\Paginator\Adapter\Model as Paginator;

class LoginController extends ControllerBase {
    public function loginVAction() {
        return $this->view->pick('index/index');
    }

    public function LoginAction() {
        //$this->view->disable();
        $response = new \Phalcon\Http\Response();
        $response->setHeader("Access-Control-Allow-Origin", "*");    
        $response->sendHeaders();
        $sesion = $this->getDI()->getShared("session");

        if ($this->request->isPost()) {
            if (!empty($_POST['usuario'])) {
                $us = $_POST['usuario'];
            } else {
                $us = null;
            }
            $usuario = Usuarios::Encontrar($us);
            if ($usuario && !empty($_POST['contraseña'])) {
                if ($this->security->checkHash($_POST['contraseña'], $usuario[0]->password)) {
                    $respuesta['exito']     = true;
                    $respuesta['token']     = $this->security->getTokenKey();
                    
                    $this->view->postId = $postId;
                    $sesion->set("us_id", $usuario->id);
                    $sesion->set("us_nombre", $usuario->nombre);
                    $sesion->set("us_apellido", $usuario->apellido);        
                } else {
                    $this->security->hash(rand());
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
        $respuesta['op'] = -1;

        return $response->setContent(
            json_encode(
                $respuesta
            )
        );
    }
}