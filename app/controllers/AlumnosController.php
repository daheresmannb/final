<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;


class AlumnosController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for alumnos
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'Alumnos', $_POST);
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
        if (count($alumnos) == 0) {
            $this->flash->notice("The search did not find any alumnos");

            $this->dispatcher->forward([
                "controller" => "alumnos",
                "action" => "index"
            ]);

            return;
        }

        $paginator = new Paginator([
            'data' => $alumnos,
            'limit'=> 10,
            'page' => $numberPage
        ]);

        $this->view->page = $paginator->getPaginate();
    }

    /**
     * Displays the creation form
     */
    public function newAction()
    {

    }

    /**
     * Edits a alumno
     *
     * @param string $id
     */
    public function editAction($id)
    {
        if (!$this->request->isPost()) {

            $alumno = Alumnos::findFirstByid($id);
            if (!$alumno) {
                $this->flash->error("alumno was not found");

                $this->dispatcher->forward([
                    'controller' => "alumnos",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->id = $alumno->id;

            $this->tag->setDefault("id", $alumno->id);
            $this->tag->setDefault("nombre", $alumno->nombre);
            $this->tag->setDefault("apellido", $alumno->apellido);
            $this->tag->setDefault("correo", $alumno->correo);
            $this->tag->setDefault("telefono", $alumno->telefono);
            $this->tag->setDefault("direccion", $alumno->direccion);
            
        }
    }

    /**
     * Creates a new alumno
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "alumnos",
                'action' => 'index'
            ]);

            return;
        }

        $alumno = new Alumnos();
        $alumno->nombre = $this->request->getPost("nombre");
        $alumno->apellido = $this->request->getPost("apellido");
        $alumno->correo = $this->request->getPost("correo");
        $alumno->telefono = $this->request->getPost("telefono");
        $alumno->direccion = $this->request->getPost("direccion");
        

        if (!$alumno->save()) {
            foreach ($alumno->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "alumnos",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("alumno was created successfully");

        $this->dispatcher->forward([
            'controller' => "alumnos",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a alumno edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "alumnos",
                'action' => 'index'
            ]);

            return;
        }

        $id = $this->request->getPost("id");
        $alumno = Alumnos::findFirstByid($id);

        if (!$alumno) {
            $this->flash->error("alumno does not exist " . $id);

            $this->dispatcher->forward([
                'controller' => "alumnos",
                'action' => 'index'
            ]);

            return;
        }

        $alumno->nombre = $this->request->getPost("nombre");
        $alumno->apellido = $this->request->getPost("apellido");
        $alumno->correo = $this->request->getPost("correo");
        $alumno->telefono = $this->request->getPost("telefono");
        $alumno->direccion = $this->request->getPost("direccion");
        

        if (!$alumno->save()) {

            foreach ($alumno->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "alumnos",
                'action' => 'edit',
                'params' => [$alumno->id]
            ]);

            return;
        }

        $this->flash->success("alumno was updated successfully");

        $this->dispatcher->forward([
            'controller' => "alumnos",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a alumno
     *
     * @param string $id
     */
    public function deleteAction($id)
    {
        $alumno = Alumnos::findFirstByid($id);
        if (!$alumno) {
            $this->flash->error("alumno was not found");

            $this->dispatcher->forward([
                'controller' => "alumnos",
                'action' => 'index'
            ]);

            return;
        }

        if (!$alumno->delete()) {

            foreach ($alumno->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "alumnos",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("alumno was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "alumnos",
            'action' => "index"
        ]);
    }

}
