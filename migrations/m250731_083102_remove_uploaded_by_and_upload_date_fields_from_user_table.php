<?php

use yii\db\Migration;

class m250731_083102_remove_uploaded_by_and_upload_date_fields_from_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $db = Yii::$app->db;
        $schema = $db->schema->getTableSchema("{{user}}");

        if (isset($schema->columns['uploaded_by']) && isset($schema->columns['upload_date'])) {
            $this->dropColumn("{{user}}", 'uploaded_by');
            $this->dropColumn("{{user}}", 'upload_date');
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $db = Yii::$app->db;
        $schema = $db->schema->getTableSchema("{{user}}");

        if (isset($schema->columns['uploaded_by']) && isset($schema->columns['upload_date'])) {
            $this->addColumn("{{user}}", 'uploaded_by', $this->integer()->null()->after('id'));
            $this->addColumn("{{user}}", 'upload_date', $this->dateTime()->null()->after('uploaded_by'));
        }

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250731_083102_remove_uploaded_by_and_upload_date_fields_from_user_table cannot be reverted.\n";

        return false;
    }
    */
}
