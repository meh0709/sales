<?php

/**
 * Class News_model
 * @property CI_DB_driver|CI_DB_sqlite3_driver $db The DB driver
 */
class News_model extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }

    public function get_news($slug = FALSE)
    {
        if ($slug === FALSE)
        {
            $query = $this->db->get('news');
            return $query->result_array();
        }

        $query = $this->db->get_where('news', array('slug' => $slug));
        return $query->row_array();
    }

    /**
     * @param string $title
     * @param string $text
     * @return mixed
     */
    public function set_news($title, $text)
    {
        $this->load->helper('url');

        $slug = url_title($title, 'dash', TRUE);
        sleep(5);
//        ваов

        $data = array(
            'title' => $title,
            'slug' => $slug,
            'text' => $text
        );

        return $this->db->insert('news', $data);
    }

    public function getKyky($ky)
    {
        sleep(5);
        if (!is_string($ky)) return;
        $ky = strtoupper($ky);
        return $ky.$ky;
    }

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
            'title' => array(
                'type' => 'VARCHAR',
                'constraint' => '128',
                'null' => FALSE,
            ),
            'slug' => array(
                'type' => 'VARCHAR',
                'constraint' => '128',
                'null' => FALSE,
            ),
            'text' => array(
                'type' => 'TEXT',
                'null' => FALSE,
            ),
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key('slug', FALSE);
        $this->dbforge->create_table('news');
    }


    public function index()
    {
        $data['news'] = $this->news_model->get_news();
        $data['title'] = 'News archive';

        $this->load->view('templates/header', $data);
        $this->load->view('news/index', $data);
        $this->load->view('templates/footer');
    }

    public function view($slug = NULL)
    {
        $data['news_item'] = $this->news_model->get_news($slug);

        if (empty($data['news_item']))
        {
            show_404();
        }

        $data['title'] = $data['news_item']['title'];

        $this->load->view('templates/header', $data);
        $this->load->view('news/view', $data);
        $this->load->view('templates/footer');
    }

    public function create()
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');

        $data['title'] = 'Create a news item';

        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('text', 'Text', 'required');

        if ($this->form_validation->run() === FALSE)
        {
            $this->load->view('templates/header', $data);
            $this->load->view('news/create');
            $this->load->view('templates/footer');
        }
        else
        {
            $this->news_model->set_news($this->input->post_get('title', true), $this->input->post_get('text', true));
            $this->load->view('templates/header', $data);
            $this->load->view('news/success');
            $this->load->view('templates/footer');
        }
    }

}
