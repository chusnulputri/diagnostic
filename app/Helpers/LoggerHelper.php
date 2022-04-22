<?php

use App\Models\m_log;

if (!function_exists('databaseLog')) {

    /**
     * @param string $userId user id from m_user
     * @param string $activity option: create, read, update, delete, approve, print
     * @param string $tableName table name
     */
    function databaseLog(
        string $userId,
        string $activity,
        string $tableName,
        string $recordId,
        string $note = null
    )
    {
        $log = new m_log();
        $log->log_user = $userId;
        $log->log_activity = $activity;
        $log->log_description = $note ?? null;
        $log->log_table = $tableName;
        $log->log_table_id = $recordId;
        $log->save();
    }
}
