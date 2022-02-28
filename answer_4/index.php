<?php
die(__FILE__);
define(ROOT, dirname(__FILE__));

$mysql = mysql_connect('localhost', 'user', 'pass');
if (!$mysql) {
    die(mysql_error());
}

if (!empty($_QUERY['system_queue'])) {
    $query = 'SELECT * FROM system_queue WHERE run_date > ' . time();

    if (is_numeric($_QUERY['system_queue'])) {
        $query.= ' AND queue_id = ' . $_QUERY['system_queue'];
    }

    $query.= ' AND status = \'pending\' LIMIT 1';

    try {
        mysql_query('START TRANSACTION;');
        $result = mysql_query($query, $mysql);
        $id = $result['0']['queue_id'];
        mysql_query('UPDATE system_queue SET status = \'in-process\' WHERE queue_id = ' . $id, $mysql);

        // Se ejecuta la funcion segun la fecha


        // Se actualiza 
        mysql_query('UPDATE system_queue SET status = \'process\' WHERE queue_id = ' . $id, $mysql);

        mysql_query('COMMIT;');
    } catch (Exception $e) {
        mysql_query('ROLLBACK;');
    }

    die;
}
else if (!empty($_POST['add_queue'])) {
    if (empty($_POST['function'])) {
        $_POST['function'] = '';
        header('Location: index.php?error');
    }

    if (!empty($_POST['run_date'])) {
        $_POST['run_date'] = strtotime($_POST['run_date']);
    }
    else {
        $_POST['run_date'] = time();
    }
    
    $_POST['status'] = 'pending';

    try {
        if (!empty($_POST['function'])) {
            mysql_query('INSERT INTO system_queue (function,run_date,status) VALUES (\'' . $_POST['function'] . '\', \'' . $_POST['run_date'] . '\', \'' . $_POST['status'] . '\')');
            $id = mysql_insert_id($mysql);
        
            if ($_POST['run_date'] <= time()) {
                // Se ejecuta la funcion segun inmediatamente por fecha.


                mysql_query('UPDATE system_queue SET status = \'process\' WHERE queue_id = ' . $id, $mysql);                
            }
            else {
                exec('0 0 1 * * #!/usr/bin/env php ' . __FILE__ . '?system_queue=' . $id . ' &> /dev/null');
            }

            header('Location: index.php?success');
        }
    } catch (Exception $e) {

    }

}

?>


<form action="index.php" type="POST">

    <div>
        <label for="RunDate">Fecha de ejecución</label>
        <input name="run_date" type="date" value="" id="RunDate">
    </div>
    <div>
        <label for="RunDate">Función</label>
        <textarea name="function" id="" cols="30" rows="10"></textarea>
    </div>

    <div>
        <button type="submit">
            Enviar
        </button>
    </div>

</form>

