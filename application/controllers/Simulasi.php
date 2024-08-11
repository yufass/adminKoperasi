<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Simulasi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        if ($this->session->userdata('login') != 1) {
            $this->session->set_flashdata('alert_message', '<div class="alert alert-danger alert-dismissible fade show"><strong>Maaf! </strong>Anda belum login.</div>');
            redirect('auth');
        }
    }

    public function index()
    {
        $data['title'] = 'Simulasi Pinjaman';
        $data['sub_title'] = 'Simulasi Pinjaman';
        $data['status'] = 'User';
        $data['corp_name'] = 'Koperasi';
        $data['kelompok'] = 'Kelompok 3';
        $data['user'] = $this->app_models->getUserTable('user');
        $data['userdata'] = $this->app_models->getUserTable('userdata');

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('simulasi/index', $data);
        $this->load->view('templates/footer');
    }
}