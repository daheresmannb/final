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
        $parameters["order"] = "codalu";

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
     * @param string $codalu
     */
    public function editAction($codalu)
    {
        if (!$this->request->isPost()) {

            $alumno = Alumnos::findFirstBycodalu($codalu);
            if (!$alumno) {
                $this->flash->error("alumno was not found");

                $this->dispatcher->forward([
                    'controller' => "alumnos",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->codalu = $alumno->codalu;

            $this->tag->setDefault("codalu", $alumno->codalu);
            $this->tag->setDefault("nomalu", $alumno->nomalu);
            $this->tag->setDefault("caralu", $alumno->caralu);
            
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
        $alumno->codalu = $this->request->getPost("codalu");
        $alumno->nomalu = $this->request->getPost("nomalu");
        $alumno->caralu = $this->request->getPost("caralu");
        

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

        $codalu = $this->request->getPost("codalu");
        $alumno = Alumnos::findFirstBycodalu($codalu);

        if (!$alumno) {
            $this->flash->error("alumno does not exist " . $codalu);

            $this->dispatcher->forward([
                'controller' => "alumnos",
                'action' => 'index'
            ]);

            return;
        }

        $alumno->codalu = $this->request->getPost("codalu");
        $alumno->nomalu = $this->request->getPost("nomalu");
        $alumno->caralu = $this->request->getPost("caralu");
        

        if (!$alumno->save()) {

            foreach ($alumno->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "alumnos",
                'action' => 'edit',
                'params' => [$alumno->codalu]
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
     * @param string $codalu
     */
    public function deleteAction($codalu)
    {
        $alumno = Alumnos::findFirstBycodalu($codalu);
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
