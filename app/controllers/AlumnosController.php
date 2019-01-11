<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class AlumnosController extends ControllerBase {

    public function indexAction() {
        return $this->view->pick('alumnos/new'); 
    } 

    public function createVAction() {
        return $this->view->pick('alumnos/new'); 
    } 

    public function createAction() {
        $response = new \Phalcon\Http\Response();
        $response->setHeader("Access-Control-Allow-Origin", "*");    
        $response->sendHeaders();

        if (!empty($_POST['nombre']) && !empty($_POST['apellido']) && !empty($_POST['correo']) && !empty($_POST['telefono']) && !empty($_POST['direccion'])) {
            $alumno = new Alumnos();
            $alumno->nombre    = $this->request->getPost("nombre");
            $alumno->apellido  = $this->request->getPost("apellido");
            $alumno->correo    = $this->request->getPost("correo");
            $alumno->telefono  = $this->request->getPost("telefono");
            $alumno->direccion = $this->request->getPost("direccion");
            $alumno->save();

            $respuesta['exito']     = true;
            $respuesta['respuesta'] = "Registro creado satisfactoriamente";
            $respuesta["op"]        = 1;
        } else {
            $respuesta['exito']     = false;
            $respuesta['respuesta'] = "Datos requeridos";
            $respuesta["op"]        = 1;
        }
        return $response->setContent(
            json_encode(
                $respuesta
            )
        );
    }

    public function readAction() {
        $response = new \Phalcon\Http\Response();
        $response->setHeader("Access-Control-Allow-Origin", "*");    
        $response->sendHeaders();

        if (!empty($_POST['alumno_id'])) {
            $alumno = Alumnos::findFirst([
                'conditions' => 'id = '.$_POST['alumno_id'],
                'order'      => 'id DESC',
            ]);

            if (!empty($alumno)) {
                $respuesta['exito']     = true;
                $respuesta['respuesta'] = $alumno;
                $respuesta["op"]        = 0;
            } else {
                $respuesta['exito']     = false;
                $respuesta['respuesta'] = "El registro no se encuentra";
                $respuesta["op"]        = 1;
            }
        } else {
            $respuesta['exito']     = true;
            $respuesta['respuesta'] = Alumnos::find();
            $respuesta['op']        = 0;
        }
        return $response->setContent(
            json_encode(
                $respuesta
            )
        );
    }

    public function updateAction() {
        $response = new \Phalcon\Http\Response();
        $response->setHeader("Access-Control-Allow-Origin", "*");    
        $response->sendHeaders();
        if (!empty($_POST['alumno_id'])) {
            $alumno = Alumnos::findFirstById($_POST['alumno_id']);

            if (!empty($alumno)) {
                $alumno->nombre    = $this->request->getPost("nombre");
                $alumno->apellido  = $this->request->getPost("apellido");
                $alumno->correo    = $this->request->getPost("correo");
                $alumno->telefono  = $this->request->getPost("telefono");
                $alumno->direccion = $this->request->getPost("direccion");
                $alumno->update();

                $respuesta['exito']     = true;
                $respuesta['respuesta'] = "Registro actualizado correctamente";
                $respuesta["op"]        = 1;
            } else {
                $respuesta['exito']     = false;
                $respuesta['respuesta'] = "El registro no se encuentra";
                $respuesta["op"]        = 1;
            }    
        } else {
            $respuesta['exito']     = false;
            $respuesta['respuesta'] = "Datos requeridos";
            $respuesta['op']        = 1;
        }
        return $response->setContent(
            json_encode(
                $respuesta
            )
        );
    }

    public function deleteAction() {
        $response = new \Phalcon\Http\Response();
        $response->setHeader("Access-Control-Allow-Origin", "*");    
        $response->sendHeaders();
        if (!empty($_POST['alumno_id'])) {
            $alumno = Alumnos::findFirst([
                'conditions' => 'id = '.$_POST['alumno_id'],
                'order'      => 'id DESC',
            ]);

            if (!empty($alumno)) {
                $alumno->delete();

                $respuesta['exito']     = true;
                $respuesta['respuesta'] = "Registro eliminado correctamente";
                $respuesta["op"]        = 1;
            } else {
                $respuesta['exito']     = false;
                $respuesta['respuesta'] = "El registro no se encuentra";
                $respuesta["op"]        = 1;
            }
        } else {
            $respuesta['exito']     = false;
            $respuesta['respuesta'] = "Datos requeridos";
            $respuesta['op']        = 1;
        }
        return $response->setContent(
            json_encode(
                $respuesta
            )
        );
    }
}