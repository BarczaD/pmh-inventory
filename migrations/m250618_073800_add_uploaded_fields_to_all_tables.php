<?php

use yii\db\Migration;

class m250618_073800_add_uploaded_fields_to_all_tables extends Migration
{
    public function safeUp()
    {
        $db = Yii::$app->db;
        $tables = $db->schema->getTableNames();

        foreach ($tables as $table) {
            if ($table === 'migration') {
                continue;
            }

            $schema = $db->schema->getTableSchema($table);

            if (!isset($schema->columns['uploaded_by'])) {
                $this->addColumn($table, 'uploaded_by', $this->integer()->null()->after('id'));
            }

            if (!isset($schema->columns['upload_date'])) {
                $this->addColumn($table, 'upload_date', $this->dateTime()->null()->after('uploaded_by'));
            }
        }
    }

    public function safeDown()
    {
        $db = Yii::$app->db;
        $tables = $db->schema->getTableNames();

        foreach ($tables as $table) {
            if ($table === 'migration') {
                continue;
            }

            $schema = $db->schema->getTableSchema($table);

            if (isset($schema->columns['uploaded_by'])) {
                $this->dropColumn($table, 'uploaded_by');
            }

            if (isset($schema->columns['upload_date'])) {
                $this->dropColumn($table, 'upload_date');
            }
        }
    }
}
