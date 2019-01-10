<?php

class VistasController extends ControllerBase {
    public function indexAction() {
        return $this->view->pick('home/home');     
    }

    public function btnaluAction() {
    	return $this->view->pick('btns_alumnos/btn_alu');   
    }

    public function mostrarAction() {
    	return $this->view->pick('alumnos/mostrar');   
    }

    public function registrarAction() {
    	return $this->view->pick('alumnos/new');   
    }

    public function eliminarAction() {
    	return $this->view->pick('alumnos/eliminar');   
    }
    
}