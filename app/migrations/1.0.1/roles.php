<?php 

use Phalcon\Db\Column;
use Phalcon\Db\Index;
use Phalcon\Db\Reference;
use Phalcon\Mvc\Model\Migration;

/**
 * Class RolesMigration_101
 */
class RolesMigration_101 extends Migration {
    public function up() {
 
        $this->morphTable('roles', [
                'columns' => [
                    new Column(
                        'id',[
                            'type' => Column::TYPE_INTEGER,
                            'notNull' => true,
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
                    )
                ],
                'indexes' => [
                    new Index('PRIMARY', ['id'], 'PRIMARY')
                ],
                'options' => [
                    'TABLE_TYPE' => 'BASE TABLE',
                    'ENGINE' => 'InnoDB',
                    'TABLE_COLLATION' => 'utf8_general_ci'
                ],
            ]
        );

        $this->getConnection()->insert(
            'roles',
            [
                1,
                "Admin",
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
            'roles'
        );
    }
}