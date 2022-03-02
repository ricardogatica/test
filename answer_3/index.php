<?php

SELECT ((MAX(approved_date) - MIN(approved_date)) / (60 * 60 * 24)) AS dias_aprovacion FROM application;

SELECT (((MAX(approved_date) - MIN(approved_date)) - (MAX(process_date) - MIN(process_date))) / (60 * 60 * 24)) AS promedio_demora_desombolso FROM application;

?>