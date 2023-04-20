<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Migration_Add_s
 * @property CI_DB_forge $dbforge The DB Forge
 */
class Migration_Add_s extends CI_Migration {

    public function up()
    {
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE,
                'null' => FALSE,
            ),
            'titleq' => array(
                'type' => 'VARCHAR',
                'constraint' => '128',
                'null' => FALSE,
            ),
            'slugq' => array(
                'type' => 'VARCHAR',
                'constraint' => '128',
                'null' => FALSE,
            ),
            'textq' => array(
                'type' => 'TEXT',
                'null' => FALSE,
            ),
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key('slugq', FALSE);
        $this->dbforge->create_table('s');
    }

    public function down()
    {
        $this->dbforge->drop_table('news');
    }
}
