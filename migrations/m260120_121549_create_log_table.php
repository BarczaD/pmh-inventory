<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%log}}`.
 */
class m260120_121549_create_log_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%log}}', [
            'id' => $this->primaryKey(),
            'log_date' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'alert_level' => $this->integer()->notNull()->defaultValue(0),
            'event_type' => $this->string(50)->notNull(),
            'event_description' => $this->text(),
            'triggered_by' => $this->integer(),
        ]);

        $this->addForeignKey(
            'fk-log-triggered_by',
            '{{%log}}',
            'triggered_by',
            '{{%user}}',
            'id',
            'SET NULL'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk-log-triggered_by', '{{%log}}');
        $this->dropTable('{{%log}}');
    }
}
