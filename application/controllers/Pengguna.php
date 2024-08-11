<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Pengguna extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');

        if ($this->session->userdata('login') != 1) {
            $this->session->set_flashdata('alert_message', '<div class="alert alert-danger alert-dismissible fade show"><strong>Maaf! </strong>Anda belum login.</div>');
            redirect('auth');
        } else {
            if ($this->session->userdata('aktif') < 2) {
                if ($this->session->userdata('level') < 2) {
                    redirect('user');
                }
            }
        }
    }

    public function index()
    {
        if ($this->session->userdata('level') == 1) {
            redirect('pengguna/profile');
        }
        // TITLE
        $data['title'] = 'Pengguna';
        $data['sub_title'] = 'Pengguna';
        $data['status'] = 'Admin';
        $data['corp_name'] = 'Koperasi';
        $data['kelompok'] = 'Kelompok 3';

        $data['user'] = $this->app_models->getUserTable('user');
        $data['userdata'] = $this->app_models->getUserTable('userdata');
        $data['userdataPengurus'] = $this->app_models->getPengurus();
        $data['userdataPengguna'] = $this->app_models->getAnggota();
        $data['tanggal'] = new DateTime();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('pengguna/index', $data);
        $this->load->view('templates/footer');
    }

    public function tambah()
    {
        $data = [
            'username' => htmlspecialchars($this->input->post('username', true)),
            'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
            'nama_lengkap' => htmlspecialchars($this->input->post('nama_lengkap', true)),
            'level' => 2,
            'aktif' => 2
        ];
        $this->db->insert('user', $data);

        $data = [
            'username' => htmlspecialchars($this->input->post('username', true)),
            'nama_lengkap' => htmlspecialchars($this->input->post('nama_lengkap', true)),
            'tempat_lahir' => '',
            'tanggal_lahir' => '',
            'jenis_kelamin' => '',
            'alamat' => '',
            'no_hp' => '',
            'profil' => ''
        ];
        $this->db->insert('userdata', $data);
        redirect('pengguna');
    }

    public function profile()
    {
        $data['title'] = 'User';
        $data['sub_title'] = 'Edit Profil';
        $data['status'] = 'Admin';
        $data['corp_name'] = 'Koperasi';
        $data['kelompok'] = 'Kelompok 3';
        $data['user'] = $this->app_models->getUserTable('user');
        $data['userdata'] = $this->app_models->getUserTable('userdata');

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('pengguna/profile', $data);
        $this->load->view('templates/footer');
    }

    public function edit_form($username)
    {
        $data['title'] = 'User';
        $data['sub_title'] = 'Edit Profil';
        $data['status'] = 'Admin';
        $data['corp_name'] = 'Koperasi';
        $data['kelompok'] = 'Kelompok 3';
        $data['user'] = $this->app_models->getUserTable('user');
        $data['userdata'] = $this->app_models->getSelectedUserDataTable($username);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('pengguna/edit_form', $data);
        $this->load->view('templates/footer');
    }

    public function edit()
    {
        $this->form_validation->set_rules('nama_lengkap', 'Name', 'required|trim', [
            'required' => 'Nama harus diisi!'
        ]);
        $this->form_validation->set_rules('tempat_lahir', 'Tempat_lahir', 'required|trim', [
            'required' => 'Tempat lahir harus diisi!'
        ]);
        $this->form_validation->set_rules('tanggal_lahir', 'Tanggal_lahir', 'required', [
            'required' => 'Tanggal lahir harus diisi!'
        ]);
        $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim', [
            'required' => 'Alamat harus diisi!'
        ]);
        $this->form_validation->set_rules('no_hp', 'No_hp', 'required|trim', [
            'required' => 'No HP harus diisi!'
        ]);

        if ($this->form_validation->run() == false) {
            $data['title'] = 'User';
            $data['sub_title'] = 'Edit Profil';
            $data['status'] = 'Admin';
            $data['corp_name'] = 'Koperasi';
            $data['kelompok'] = 'Kelompok 3';
            $data['user'] = $this->app_models->getUserTable('user');
            $data['userdata'] = $this->app_models->getUserTable('userdata');

            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('pengguna/edit_form', $data);
            $this->load->view('templates/footer');
        } else {
            $data = [
                'username' => htmlspecialchars($this->input->post('username', true)),
                'nama_lengkap' => htmlspecialchars($this->input->post('nama_lengkap', true)),
                'tempat_lahir' => htmlspecialchars($this->input->post('tempat_lahir', true)),
                'tanggal_lahir' => $this->input->post('tanggal_lahir'),
                'jenis_kelamin' => htmlspecialchars($this->input->post('jenis_kelamin', true)),
                'alamat' => htmlspecialchars($this->input->post('alamat', true)),
                'no_hp' => htmlspecialchars($this->input->post('no_hp', true)),
                'profil' => 'default.jpg'
            ];
            $this->db->where('username', $data['username']);
            $this->db->update('userdata', $data);

            $user = $this->db->get_where('user', ['username' => $data['username']])->row_array();

            $this->session->set_flashdata('alert_message', '<div class="alert alert-success alert-dismissible fade show"><strong>Selamat! </strong>Anda berhasil merubah data.</div>');
            redirect('pengguna');
        }
    }

    public function hapus($username)
    {
        $this->app_models->deleteSelectedUser($username);

        $this->session->set_flashdata('alert_message', '<div class="alert alert-danger alert-dismissible fade show"><strong>Berhasil! </strong>Data dihapus.</div>');
        redirect('pengguna');
    }

    public function aktif($username)
    {
        $this->app_models->setAktif($username);

        $this->session->set_flashdata('alert_message', '<div class="alert alert-success alert-dismissible fade show"><strong>Selamat! </strong>Anda berhasil mengaktifkan user.</div>');
        redirect('pengguna');
    }

    public function nonaktif($username)
    {
        $this->app_models->setNonaktif($username);

        $this->session->set_flashdata('alert_message', '<div class="alert alert-success alert-dismissible fade show"><strong>Selamat! </strong>Anda berhasil menonaktifkan user.</div>');
        redirect('pengguna');
    }

    public function edit_profile()
    {
        $this->app_models->editProfile();
    }
}