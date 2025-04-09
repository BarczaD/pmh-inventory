<?php

use yii\db\Migration;

class m250409_115814_init_full_schema extends Migration
{
    public function safeUp()
    {
        // === USER ===
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'password' => $this->string()->notNull(),
            'auth_token' => $this->string(),
            'access_token' => $this->string(),
        ]);

        // === BRAND ===
        $this->createTable('{{%brand}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->unique(),
        ]);

        // === CPU ===
        $this->createTable('{{%cpu}}', [
            'id' => $this->primaryKey(),
            'brand' => $this->string()->notNull(),
            'model' => $this->string()->notNull(),
        ]);

        // === COLLEAGUE ===
        $this->createTable('{{%colleague}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'department' => $this->string(),
            'group' => $this->string(),
            'archived' => $this->boolean()->defaultValue(false),
        ]);

        // === OFFICE ===
        $this->createTable('{{%office}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
        ]);

        // === MONITOR ===
        $this->createTable('{{%monitor}}', [
            'id' => $this->primaryKey(),
            'brand' => $this->string()->notNull(),
            'model' => $this->string()->notNull(),
            's_n' => $this->string(), // serial number
            'i_n' => $this->string(), // inventory number
            'description' => $this->text(),
        ]);

        // === WORKSTATION ===
        $this->createTable('{{%workstation}}', [
            'id' => $this->primaryKey(),
            'hostname' => $this->string()->notNull()->unique(),
            'brand_id' => $this->integer(),
            'cpu_id' => $this->integer(),
            'ram' => $this->string()->notNull(),
            'os' => $this->string()->notNull(),
            'colleague_id' => $this->integer(),
            'office_id' => $this->integer(),
            'monitor_id1' => $this->integer(),
            'monitor_id2' => $this->integer(),
            'ms_office_license' => $this->boolean()->defaultValue(false),
            'software_list' => $this->json(),
            'description' => $this->text(),
        ]);

        // === MAINTENANCE ===
        $this->createTable('{{%maintenance}}', [
            'id' => $this->primaryKey(),
            'date' => $this->date()->notNull(),
            'workstation_id' => $this->integer()->notNull(),
            'hardware' => $this->boolean()->defaultValue(false),
            'software' => $this->boolean()->defaultValue(false),
            'description' => $this->text(),
        ]);

        // === INDEXES & FOREIGN KEYS ===
        $this->addForeignKey('fk-workstation-brand', '{{%workstation}}', 'brand_id', '{{%brand}}', 'id', 'SET NULL');
        $this->addForeignKey('fk-workstation-cpu', '{{%workstation}}', 'cpu_id', '{{%cpu}}', 'id', 'SET NULL');
        $this->addForeignKey('fk-workstation-colleague', '{{%workstation}}', 'colleague_id', '{{%colleague}}', 'id', 'SET NULL');
        $this->addForeignKey('fk-workstation-office', '{{%workstation}}', 'office_id', '{{%office}}', 'id', 'SET NULL');
        $this->addForeignKey('fk-workstation-monitor1', '{{%workstation}}', 'monitor_id1', '{{%monitor}}', 'id', 'SET NULL');
        $this->addForeignKey('fk-workstation-monitor2', '{{%workstation}}', 'monitor_id2', '{{%monitor}}', 'id', 'SET NULL');

        $this->addForeignKey('fk-maintenance-workstation', '{{%maintenance}}', 'workstation_id', '{{%workstation}}', 'id', 'CASCADE');
    }

    public function safeDown()
    {
        // Drop in reverse order to avoid FK violations
        $this->dropForeignKey('fk-maintenance-workstation', '{{%maintenance}}');
        $this->dropForeignKey('fk-workstation-monitor2', '{{%workstation}}');
        $this->dropForeignKey('fk-workstation-monitor1', '{{%workstation}}');
        $this->dropForeignKey('fk-workstation-office', '{{%workstation}}');
        $this->dropForeignKey('fk-workstation-colleague', '{{%workstation}}');
        $this->dropForeignKey('fk-workstation-cpu', '{{%workstation}}');
        $this->dropForeignKey('fk-workstation-brand', '{{%workstation}}');

        $this->dropTable('{{%maintenance}}');
        $this->dropTable('{{%workstation}}');
        $this->dropTable('{{%monitor}}');
        $this->dropTable('{{%office}}');
        $this->dropTable('{{%colleague}}');
        $this->dropTable('{{%cpu}}');
        $this->dropTable('{{%brand}}');
        $this->dropTable('{{%user}}');
    }
}
