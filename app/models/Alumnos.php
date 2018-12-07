<?php

class Alumnos extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var string
     */
    public $codalu;

    /**
     *
     * @var string
     */
    public $nomalu;

    /**
     *
     * @var string
     */
    public $caralu;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("final");
        $this->setSource("alumnos");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'alumnos';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Alumnos[]|Alumnos|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Alumnos|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
