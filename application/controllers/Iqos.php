<?php

/**
 * Class News
 * @property News_model $iqos_model The News model
 * @property CI_Form_validation $form_validation The form validation lib
 * @property CI_Input $input The input lib
 */
class Iqos extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('iqos_model');
        $this->load->helper('url_helper');
    }

    public function index()
    {
        $data['iqos'] = $this->iqos_model->get_iqos();
        $data['title'] = 'News archive';

        $this->load->view('templates/header', $data);
        $this->load->view('iqos/index', $data);
        $this->load->view('templates/footer');
    }

    public function view($slug = NULL)
    {
        $data['iqos_item'] = $this->iqos_model->get_iqos($slug);

        if (empty($data['iqos_item']))
        {
            show_404();
        }

        $data['title'] = $data['iqos_item']['title'];

        $this->load->view('templates/header', $data);
        $this->load->view('iqos/view', $data);
        $this->load->view('templates/footer');
    }

    public function create()
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');

        $data['title'] = 'Create a iqos item';

        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('text', 'Text', 'required');

        if ($this->form_validation->run() === FALSE)
        {
            $this->load->view('templates/header', $data);
            $this->load->view('iqos/create');
            $this->load->view('templates/footer');
        }
        else
        {
            $this->iqos_model->set_iqos($this->input->post_get('title', true), $this->input->post_get('text', true));
            $this->load->view('templates/header', $data);
            $this->load->view('iqos/success');
            $this->load->view('templates/footer');
        }
    }

}
