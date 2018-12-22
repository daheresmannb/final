<?php

namespace MicheleAngioni\PhalconAuth\Tests;

use Phalcon\Db\Column;
use Phalcon\Db\Index;
use Phalcon\Di;
use Phalcon\Loader;
use Phalcon\Test\UnitTestCase as PhalconTestCase;

abstract class TestCase extends PhalconTestCase
{
    protected $_cache;

    /**
     * @var \Phalcon\Config
     */
    protected $_config;

    /**
     * @var bool
     */
    private $_loaded = false;


    public function setUp()
    {
        parent::setUp();

        // Load any additional services that might be required during testing
        $di = Di::getDefault();

        $di->set('modelsManager', function () {
            return new \Phalcon\Mvc\Model\Manager();
        });

        $di->set('modelsMetadata', function () {
            return new \Phalcon\Mvc\Model\Metadata\Memory();
        });

        $di->set('security', function () {
            $security = new \Phalcon\Security();

            return $security;
        }, true);

        $di->set('session', function () {
            $session = new \Phalcon\Session\Adapter\Files();
            $session->start();

            return $session;
        });

        /**
         * Database connection is created based in the parameters defined in the configuration file
         */
        $di->set('db', function () {
            return new \Phalcon\Db\Adapter\Pdo\Sqlite ([
                'dbname' => dirname(__DIR__) . '/tests/temp/db_sqlite_test.sqlite'
            ]);
        });

        $this->setDi($di);

        $this->_loaded = true;

        // Drop tables
        $this->dropTables($di->get('db'));

        // Migrate the DB
        $this->migrateTables($di->get('db'));

        // Seed the DB
        $this->seedDatabase($di->get('db'));
    }


    protected function migrateTables($connection)
    {
        $connection->createTable(
            'users',
            null,
            [
                'columns' => [
                    new Column(
                        'id',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'unsigned' => true,
                            'notNull' => true,
                            'autoIncrement' => true,
                            'size' => 10,
                            'first' => true
                        ]
                    ),
                    new Column(
                        'email',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 20,
                            'after' => 'id'
                        ]
                    ),
                    new Column(
                        'password',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 60,
                            'after' => 'email'
                        ]
                    ),
                    new Column(
                        'confirmation_code',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 60,
                            'after' => 'password'
                        ]
                    ),
                    new Column(
                        'confirmed',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'size' => 1,
                            'after' => 'confirmation_code'
                        ]
                    ),
                    new Column(
                        'banned',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'size' => 1,
                            'after' => 'confirmed'
                        ]
                    ),
                    new Column(
                        'remember_token',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'size' => 20,
                            'after' => 'confirmed'
                        ]
                    ),
                    new Column(
                        'text',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'size' => 30,
                            'after' => 'remember_token'
                        ]
                    )
                ],
                'indexes' => [
                    new Index('PRIMARY', ['id'], 'PRIMARY'),
                    new Index('username_UNIQUE', ['email'], 'UNIQUE')
                ],
                'options' => [
                    'TABLE_TYPE' => 'BASE TABLE',
                    'AUTO_INCREMENT' => '18',
                    'ENGINE' => 'InnoDB',
                    'TABLE_COLLATION' => 'utf8_general_ci'
                ]
            ]
        );
    }

    protected function seedDatabase($connection)
    {

    }

    protected function dropTables($connection)
    {
        $connection->dropTable('users');
    }

    protected function tearDown()
    {
        $di = $this->getDI();
        $connection = $di->get('db');

        $di->get('modelsMetadata')->reset();

        $this->dropTables($connection);

        parent::tearDown();
    }

    /**
     * Check if the test case is setup properly
     *
     * @throws \PHPUnit_Framework_IncompleteTestError;
     */
    public function __destruct()
    {
        if (!$this->_loaded) {
            throw new \PHPUnit_Framework_IncompleteTestError('Please run parent::setUp().');
        }
    }
}
