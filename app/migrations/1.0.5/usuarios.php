<?php 

use Phalcon\Db\Column;
use Phalcon\Db\Index;
use Phalcon\Db\Reference;
use Phalcon\Mvc\Model\Migration;

/**
 * Class UsuariosMigration_105
 */
class UsuariosMigration_105 extends Migration {

    public function up() {
        $this->morphTable('usuarios', [
                'columns' => [
                    new Column(
                        'id',[
                            'type' => Column::TYPE_INTEGER,
                            'notNull' => true,
                            'autoIncrement' => true,
                            'size' => 11,
                            'first' => true
                        ]
                    ),
                    new Column(
                        'nombre',[
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 35,
                            'after' => 'id'
                        ]
                    ),
                    new Column(
                        'apellido',[
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 35,
                            'after' => 'nombre'
                        ]
                    ),
                    new Column(
                        'correo',[
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 35,
                            'after' => 'apellido'
                        ]
                    ),
                    new Column(
                        'password',[
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 35,
                            'after' => 'correo'
                        ]
                    ),
                    new Column(
                        'rol_id',[
                            'type' => Column::TYPE_INTEGER,
                            'notNull' => true,
                            'autoIncrement' => true,
                            'size' => 11,
                            'first' => true
                        ]
                    )
                ],
                'indexes' => [
                    new Index('PRIMARY', ['id', 'correo'], 'PRIMARY'),
                    new Index('roles_ibfk_1', ['rol_id'], null)
                ],
                'references' => [
                    new Reference(
                        'roles_ibfk_1',
                        [
                            'referencedSchema'  => 'final',
                            'referencedTable'   => 'roles',
                            'columns'           => ['rol_id'],
                            'referencedColumns' => ['id'],
                        ]
                    ),
                ],
                'options' => [
                    'TABLE_TYPE' => 'BASE TABLE',
                    'ENGINE' => 'InnoDB',
                    'TABLE_COLLATION' => 'utf8_general_ci'
                ],
            ]
        );
    }

    /**
     * Reverse the migrations
     *
     * @return void
     */
    public function down() {
    }
}
