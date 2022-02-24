<?php
$mysql = mysql_connect('localhost', 'user', 'pass');
if (!$mysql) {
    die(mysql_error());
}
?>


<table>
    <thead>
        <tr>
            <th>Intentos</th>
            <th>Usuario</th>
            <th>Sucursal</th>
        </tr>
    </thead>
    <tbody>
        
<?php
$result = mysql_query('SELECT COUNT(*) attempts, user_id, branch_id FROM logins WHERE distance > 10 GROUP BY branch_id, user_id;');
while ($row = mysql_fetch_assoc($result)):
?>

        <tr>
            <td><?= $row['attempts']; ?></td>
            <td><?= $row['user_id']; ?></td>
            <td><?= $row['branch_id']; ?></td>
        </tr>

    echo ;
    echo $row['apellido'];
    echo $fila['direccion'];
    echo $fila['edad'];

<?php
endwhile;
mysql_close($mysql);
?>

    </tbody>
</table>