<?php 

use Phalcon\Db\Column;
use Phalcon\Db\Index;
use Phalcon\Db\Reference;
use Phalcon\Mvc\Model\Migration;

/**
 * Class UsuariosMigration_101
 */
class UsuariosMigration_101 extends Migration {

    public function up() {
        $this->morphTable('usuarios', [
                'columns' => [
                    new Column(
                        'id',[
                            'type' => Column::TYPE_INTEGER,
                            'unsigned'      => true,
                            'notNull'       => true,
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
                            'size' => 100,
                            'after' => 'correo'
                        ]
                    ),
                    new Column(
                        'rol_id',[
                            'type' => Column::TYPE_INTEGER,
                            'notNull' => true,
                            'size' => 11,
                            'first' => true
                        ]
                    )
                ],
                'indexes' => [
                    new Index('PRIMARY', ['id'], 'PRIMARY'),
                    new Index('correo', ['correo'], 'UNIQUE')
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
        $this->getConnection()->dropTable(
            'usuarios'
        );
    }
}
