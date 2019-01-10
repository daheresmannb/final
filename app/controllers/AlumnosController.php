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

        if (!empty($_POST['nombre']) && !empty($_POST['apellido']) && !empty($_POST['correo']) && !empty($_POST['telefono']) && !empty($_POST['direccion'])) {
            $alumno = new Alumnos();
            $alumno->nombre    = $this->request->getPost("nombre");
            $alumno->apellido  = $this->request->getPost("apellido");
            $alumno->correo    = $this->request->getPost("correo");
            $alumno->telefono  = $this->request->getPost("telefono");
            $alumno->direccion = $this->request->getPost("direccion");
            $alumno->save();

            $respuesta['exito']     = true;
            $respuesta['respuesta'] = $alumno;
        } else {
            $respuesta['exito']     = false;
            $respuesta['respuesta'] = "Datos requeridos";
        }
        
        $response->setHeader("Access-Control-Allow-Origin", "*");    
        $response->sendHeaders();
        return $response->setContent(
            json_encode(
                $respuesta
            )
        );
    }

    public function readAction() {
        $response = new \Phalcon\Http\Response();

        if (!empty($_POST['alumno_id'])) {
            $numberPage = 1;
            if ($this->request->isPost()) {
                $query = Criteria::fromInput(
                    $this->di, 
                    'Alumnos', 
                    $_POST
                );
                $this->persistent->parameters = $query->getParams();
            } else {
                $numberPage = $this->request->getQuery("page", "int");
            }

            $parameters = $this->persistent->parameters;
            if (!is_array($parameters)) {
                $parameters = [];
            }
            $parameters["order"] = "id";

            $alumnos = Alumnos::find($parameters);

            $respuesta['exito']     = true;
            $respuesta['respuesta'] = $alumnos;
            $respuesta["op"] = 2;
        } else {
            $respuesta['exito']     = true;
            $respuesta['respuesta'] = Alumnos::find();
            $respuesta['op']        = 2;
        }
        
        $response->setHeader("Access-Control-Allow-Origin", "*");    
        $response->sendHeaders();
        return $response->setContent(
            json_encode(
                $respuesta
            )
        );
    }


    public function deleteAction() {
        $response = new \Phalcon\Http\Response();

        if (!empty($_POST['alumno_id'])) {
            $numberPage = 1;
            if ($this->request->isPost()) {
                $query = Criteria::fromInput(
                    $this->di, 
                    'Alumnos', 
                    $_POST
                );
                $this->persistent->parameters = $query->getParams();
            } else {
                $numberPage = $this->request->getQuery("page", "int");
            }

            $parameters = $this->persistent->parameters;
            if (!is_array($parameters)) {
                $parameters = [];
            }
            $parameters["order"] = "id";

            $alumnos = Alumnos::find($parameters);
            $alumnos->delete();

            $respuesta['exito']     = true;
            $respuesta['respuesta'] = "Registro eliminado correctamente";
            $respuesta["op"] = 4;
        } else {
            $respuesta['exito']     = true;
            $respuesta['respuesta'] = "Datos requeridos";
            $respuesta['op']        = 4;
        }
        
        $response->setHeader("Access-Control-Allow-Origin", "*");    
        $response->sendHeaders();
        return $response->setContent(
            json_encode(
                $respuesta
            )
        );
    }

}