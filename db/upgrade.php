<?php

function xmldb_plagiarism_copybridge_upgrade($oldversion) {
    global $CFG;

    $result = TRUE;

    /*if ($oldversion < XXXXXXXXXX) {

        // Define table plagiarism_copybridge to be created.
        $table = new xmldb_table('plagiarism_copybridge');

        // Adding fields to table plagiarism_copybridge.
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('cm', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('courseid', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('assignid', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('isused', XMLDB_TYPE_INTEGER, '1', null, XMLDB_NOTNULL, null, '1');
        $table->add_field('isopen', XMLDB_TYPE_INTEGER, '1', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('temp_configid', XMLDB_TYPE_CHAR, '1000', null, null, null, null);

        // Adding keys to table plagiarism_copybridge.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, ['id']);

        // Adding indexes to table plagiarism_copybridge.
        $table->add_index('cm_open', XMLDB_INDEX_NOTUNIQUE, ['cm', 'isopen']);
        $table->add_index('courseid', XMLDB_INDEX_NOTUNIQUE, ['courseid']);
        $table->add_index('isused', XMLDB_INDEX_NOTUNIQUE, ['isused']);

        // Conditionally launch create table for plagiarism_copybridge.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // Copybridge savepoint reached.
        upgrade_plugin_savepoint(true, XXXXXXXXXX, 'plagiarism', 'copybridge');
    }*/

    return $result;
}
?>