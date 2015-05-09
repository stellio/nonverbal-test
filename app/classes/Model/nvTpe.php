<?php
/*
Plugin Name: WP Tree Test
Plugin URI: http://www.stellio.org.ua
Description: A simple and powerfull plugin to make tree tests
Author: Lisovoy Igor
Author URI: http://www.stellio.org.ua
*/

class Model_nvTpe extends Core_Model
{

    private $_id = 0;
    private $_test_id = 0;
    private $_name = '';
    private $_code = '';
    private $_sequence_of_sign = '';
    private $_type = 0;


    public function setId($id)
    {
        $this->_id = (int)$id;
    }

    public function getId()
    {
        return $this->_id;
    }

    public function setTestId($id)
    {
        $this->_test_id = (int)$id;
    }

    public function getTestId()
    {
        return $this->_test_id;
    }

    public function setName($name)
    {
        $this->_name = (string)$name;
    }

    public function getName()
    {
        return $this->_name;
    }

    public function setCode($code)
    {
        $this->_code = (string)$code;
    }

    public function getCode()
    {
        return $this->_code;
    }

    public function setSequenceOfSign($sequence)
    {
        $this->_sequence_of_sign = (string)$sequence;
    }

    public function getSequenceOfSign()
    {
        return $this->_sequence_of_sign;
    }

    public function setType($type)
    {
        $this->_type = (int)$type;
    }

    public function getType()
    {
        return $this->_type;
    }

    public function loadByCodeAndTestId($code, $id) {

        $id = (int)$id;
        $result = false;

        if ($id) {

            $query = 'SELECT * FROM ' . $this->_tableTpe . ' WHERE test_id=' . $id . ' AND code="'. $code.'"';

            $object = $this->_db->get_row($query);

            $this->_id = $object->id;
            $this->_test_id = $object->test_id;
            $this->_name = $object->name;
            $this->_code = $object->code;
            $this->_sequence_of_sign = $object->sequence_of_sign;
            $this->_type = $object->type;

            return $this;
        } else {
            return $result;
        }
    }


    public function loadByTest($testId)
    {

        $result = false;

        if ($testId) {

            $query = 'SELECT * FROM ' . $this->_tableTpe . ' WHERE test_id=' . $testId;
            $result = $this->_db->get_results($query);

        }
        return $result;
    }

    public function loadById($id)
    {

        $id = (int)$id;
        $result = false;

        if ($id) {

            $query = 'SELECT * FROM ' . $this->_tableTpe . ' WHERE id=' . $id;

            $object = $this->_db->get_row($query);

            $this->_id = $object->id;
            $this->_test_id = $object->test_id;
            $this->_name = $object->name;
            $this->_code = $object->code;
            $this->_sequence_of_sign = $object->sequence_of_sign;
            $this->_type = $object->type;

            return $this;
        } else {
            return $result;
        }
    }

    public function update($id)
    {

        $id = (int)$id;
        $result = false;

        if ($id) {

            $result = $this->_db->update(
                $this->_tableTpe,
                array(                              // values
                    'test_id' => $this->_test_id,
                    'name' => $this->_name,
                    'code' => $this->_code,
                    'sequence_of_sign' => $this->_sequence_of_sign,
                    'type' => $this->_type
                ),
                array('id' => $id),                // conditions
                array('%d', '%s', '%s', '%s', '%d'),
                array('%d')
            );

            if ($result === 0)
                $result = true;
        }
        return $result;
    }


    public function save()
    {

        $result = $this->_db->insert(
            $this->_tableTpe,
            array(
                'test_id' => $this->_test_id,
                'name' => $this->_name,
                'code' => $this->_code,
                'sequence_of_sign' => $this->_sequence_of_sign,
                'type' => $this->_type
            )
        );

        if ($result) {
            $this->_id = $this->_db->insert_id;
        }

        return $result;
    }

    public function delete($id)
    {

        $result = false;
        $id = (int)$id;

        if ($id) {
            $result = $this->_db->delete(
                $this->_tableTpe,
                array('id' => $id),
                array('%d')
            );
        }
        return $result;
    }
}
?>