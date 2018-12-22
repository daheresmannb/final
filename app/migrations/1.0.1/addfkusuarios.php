<?php 

use Phalcon\Db\Column;
use Phalcon\Db\Index;
use Phalcon\Db\Reference;
use Phalcon\Mvc\Model\Migration;
use Phalcon\Security;

/**
 * Class RolesMigration_101
 */
class AddfkusuariosMigration_101 extends Migration {
    public function up() {
        $this->getConnection()->execute('SET GLOBAL FOREIGN_KEY_CHECKS=0;');
        
        $this->getConnection()->addForeignKey(
            "usuarios", 
            "final", 
            new Reference(
                'roles_ibfk_1',
                [
                    'referencedSchema'  => 'final',
                    'referencedTable'   => 'roles',
                    'columns'           => ['rol_id'],
                    'referencedColumns' => ['id'],
                ]
            )
        );
        
        $this->getConnection()->execute('SET GLOBAL FOREIGN_KEY_CHECKS=1;');

        $seguridad = new Security();
        
        $this->getConnection()->insert('usuarios',[
            1,
            "Daniel",
            "Heresmann",
            "dheresmann2012@alu.uct.cl",
            $seguridad->hash("12345678"),
            1
        ]);
    }

    /**
     * Reverse the migrations
     *
     * @return void
     */
    public function down() {

    }
}