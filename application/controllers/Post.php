<?php

/**
 * Class News
 * @property News_model $post_model The News model
 * @property CI_Form_validation $form_validation The form validation lib
 * @property CI_Input $input The input lib
 */
class Post extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('post_model');
        $this->load->helper('url_helper');
    }

    public function index()
    {
        $data['post'] = $this->post_model->get_post();
        $data['title'] = 'News archive';

        $this->load->view('templates/header', $data);
        $this->load->view('post/index', $data);
        $this->load->view('templates/footer');
    }

    public function view($slug = NULL)
    {
        $data['post_item'] = $this->post_model->get_post($slug);

        if (empty($data['post_item']))
        {
            show_404();
        }

        $data['title'] = $data['post_item']['title'];

        $this->load->view('templates/header', $data);
        $this->load->view('post/view', $data);
        $this->load->view('templates/footer');
    }

    public function create()
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');

        $data['title'] = 'Create a post item';

        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('text', 'Text', 'required');

        if ($this->form_validation->run() === FALSE)
        {
            $this->load->view('templates/header', $data);
            $this->load->view('post/create');
            $this->load->view('templates/footer');
        }
        else
        {
            $this->post_model->set_post($this->input->post_get('title', true), $this->input->post_get('text', true));
            $this->load->view('templates/header', $data);
            $this->load->view('post/success');
            $this->load->view('templates/footer');
        }
    }

}
