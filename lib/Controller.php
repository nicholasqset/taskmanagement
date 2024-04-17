<?php

/**
 * Description of Controller
 *
 * @author nicholasgakumo@gmail.com
 */

class Controller {

    public function save() {
        global $db;
//        var_dump($db);
//        $db->debug = 1;

        $data = array();

        $tskname = filter_input(INPUT_POST, 'tskname');
        $tskdate = filter_input(INPUT_POST, 'tskdate');
        $tskpriority = filter_input(INPUT_POST, 'tskpriority');
        $tskstatus = filter_input(INPUT_POST, 'tskstatus');

        $orm = new ADODB_Active_Record('taskmanagement', array("ID"), $db);
        
        $orm->tskname = $tskname;
        $orm->tskdate = $tskdate;
        $orm->tskpriority = $tskpriority;
        $orm->tskstatus = $tskstatus;

        if (!$orm->Save()) {
            $data['status'] = 0;
            $data['message'] = 'Fail: ' . $orm->ErrorMsg();
        } else {
            $data['status'] = 1;
            $data['message'] = 'Success';


        }

        return json_encode($data);
    }

    public function update() {
        global $db;
//        var_dump($db);
//        $db->debug = 1;

        $data = array();

        $id = filter_input(INPUT_POST, 'id');
        $tskname = filter_input(INPUT_POST, 'tskname');
        $tskdate = filter_input(INPUT_POST, 'tskdate');
        $tskpriority = filter_input(INPUT_POST, 'tskpriority');
        $tskstatus = filter_input(INPUT_POST, 'tskstatus');

        $orm = new ADODB_Active_Record('taskmanagement', array("ID"), $db);
        $orm->Load('id='.$id);
        
        $orm->tskname = $tskname;
        $orm->tskdate = $tskdate;
        $orm->tskpriority = $tskpriority;
        $orm->tskstatus = $tskstatus;

        if (!$orm->Save()) {
            $data['status'] = 0;
            $data['message'] = 'Fail: ' . $orm->ErrorMsg();
        } else {
            $data['status'] = 1;
            $data['message'] = 'Success';


        }

        return json_encode($data);
    }
    
    public function delete() {
        global $db;
        $id = filter_input(INPUT_POST, 'id');
        $delete = $db->Execute("DELETE FROM taskmanagement where id = ".$id);
        if (!$delete->Save()) {
            $data['status'] = 0;
            $data['message'] = 'Fail: ' . $orm->ErrorMsg();
        } else {
            $data['status'] = 1;
            $data['message'] = 'Success';
        }
        return json_encode($data);
    }
    
}
