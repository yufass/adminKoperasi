<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Laporan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
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
        $data['title'] = 'Laporan';
        $data['sub_title'] = 'Laporan';
        $data['status'] = 'User';
        $data['corp_name'] = 'Koperasi';
        $data['kelompok'] = 'Kelompok 3';
        $data['user'] = $this->app_models->getUserTable('user');
        $data['userdata'] = $this->app_models->getUserTable('userdata');

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('laporan/index', $data);
        $this->load->view('templates/footer');
    }

    public function bukti()
    {
        $data['title'] = 'Laporan';
        $data['sub_title'] = 'Bukti Bayar';
        $data['status'] = 'User';
        $data['corp_name'] = 'Koperasi';
        $data['kelompok'] = 'Kelompok 3';
        $data['user'] = $this->app_models->getUserTable('user');
        $data['userdata'] = $this->app_models->getUserTable('userdata');
        $data['tanggal'] = new DateTime();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('laporan/bukti', $data);
        $this->load->view('templates/footer');
    }

    public function proses($jenis, $tgl_awal, $tgl_akhir, $jenis_laporan)
    {
        $full = [$jenis, $tgl_awal, $tgl_akhir, $jenis_laporan];
        $this->session->set_flashdata('full', $full);
        redirect('laporan/print');
    }

    public function print()
    {
        $full = $this->session->flashdata('full');
        $jenis = $full[0];
        $tgl_awal = $full[1];
        $tgl_akhir = $full[2];
        $jenis_laporan = $full[3];

        $filter = [
            $tgl_awal, $tgl_akhir, $jenis_laporan, $jenis
        ];

        if ($jenis == 'pdf') {
            if ($jenis_laporan == '') {
                $this->session->set_flashdata('alert_message', '<div class="alert alert-danger alert-dismissible fade show"><strong>Gagal! </strong>Jenis Laporan wajib diisi!</div>');
                redirect('laporan');
            } else {
                if ($tgl_awal != '' && $tgl_akhir == '') {
                    $this->session->set_flashdata('alert_message', '<div class="alert alert-danger alert-dismissible fade show"><strong>Gagal! </strong>Silahkan isi tanggal akhir.</div>');
                    redirect('laporan');
                } elseif ($tgl_awal == '' && $tgl_akhir != '') {
                    $this->session->set_flashdata('alert_message', '<div class="alert alert-danger alert-dismissible fade show"><strong>Gagal! </strong>Silahkan isi tanggal awal.</div>');
                    redirect('laporan');
                } elseif ($tgl_awal == '' && $tgl_akhir == '') {
                    if ($jenis_laporan == 'pinjaman') {
                        redirect('laporan/printPinjaman');
                    }
                    $this->session->set_flashdata('jenis_simpanan', $jenis_laporan);
                    redirect('laporan/printSimpanan');
                } else {
                    $this->session->set_flashdata('filter', $filter);
                    redirect('laporan/printTanggalAndJenis');
                }
            }
        } elseif ($jenis == 'excel') {
            if ($jenis_laporan == '') {
                $this->session->set_flashdata('alert_message', '<div class="alert alert-danger alert-dismissible fade show"><strong>Gagal! </strong>Jenis Laporan wajib diisi!</div>');
                redirect('laporan');
            } else {
                if ($tgl_awal != '' && $tgl_akhir == '') {
                    $this->session->set_flashdata('alert_message', '<div class="alert alert-danger alert-dismissible fade show"><strong>Gagal! </strong>Silahkan isi tanggal akhir.</div>');
                    redirect('laporan');
                } elseif ($tgl_awal == '' && $tgl_akhir != '') {
                    $this->session->set_flashdata('alert_message', '<div class="alert alert-danger alert-dismissible fade show"><strong>Gagal! </strong>Silahkan isi tanggal awal.</div>');
                    redirect('laporan');
                } elseif ($tgl_awal == '' && $tgl_akhir == '') {
                    if ($jenis_laporan == 'pinjaman') {
                        redirect('laporan/printPinjamanExcel');
                    }
                    $this->session->set_flashdata('jenis_simpanan', $jenis_laporan);
                    redirect('laporan/printSimpananExcel');
                } else {
                    $this->session->set_flashdata('filter', $filter);
                    redirect('laporan/PrintTanggalAndJenisExcel');
                }
            }
        }
    }

    public function cekLaporan()
    {
        $jenis_laporan = $this->input->post('jenis_laporan');
        $tgl_awal = $this->input->post('tgl_awal');
        $tgl_akhir = $this->input->post('tgl_akhir');
        $data['tgl_awal'] = $tgl_awal;
        $data['tgl_akhir'] = $tgl_akhir;
        $data['jenis_laporan'] = $jenis_laporan;

        if ($jenis_laporan == '') {
            $this->session->set_flashdata('alert_message', '<div class="alert alert-danger alert-dismissible fade show"><strong>Gagal! </strong>Jenis Laporan wajib diisi!</div>');
            redirect('laporan');
        } else {
            if ($tgl_awal != '' && $tgl_akhir == '') {
                $this->session->set_flashdata('alert_message', '<div class="alert alert-danger alert-dismissible fade show"><strong>Gagal! </strong>Silahkan isi tanggal akhir.</div>');
                redirect('laporan');
            } elseif ($tgl_awal == '' && $tgl_akhir != '') {
                $this->session->set_flashdata('alert_message', '<div class="alert alert-danger alert-dismissible fade show"><strong>Gagal! </strong>Silahkan isi tanggal awal.</div>');
                redirect('laporan');
            } elseif ($tgl_awal == '' && $tgl_akhir == '') {
                if ($jenis_laporan == 'pinjaman') {
                    $data['title'] = 'Laporan';
                    $data['sub_title'] = 'Laporan Pinjaman';
                    $data['status'] = 'User';
                    $data['corp_name'] = 'Koperasi';
                    $data['kelompok'] = 'Kelompok 3';
                    $data['user'] = $this->app_models->getUserTable('user');
                    $data['userdata'] = $this->app_models->getUserTable('userdata');
                    $data['tanggal'] = new DateTime();

                    $data['pinjaman'] = $this->print_models->getPinjaman();
                    $data['totalPinjaman'] = $this->print_models->getTotalPinjaman();
                    $data['totalBunga'] = $this->print_models->getBunga();

                    $this->load->view('templates/header', $data);
                    $this->load->view('templates/navbar', $data);
                    $this->load->view('templates/sidebar', $data);
                    $this->load->view('laporan/cekLaporanPinjaman', $data);
                    $this->load->view('templates/footer');
                } else {
                    if ($jenis_laporan == 'simpananPokok') {
                        $jenis_laporan = 'Simpanan Pokok';
                    } elseif ($jenis_laporan == 'simpananWajib') {
                        $jenis_laporan = 'Simpanan Wajib';
                    } elseif ($jenis_laporan == 'simpananSukarela') {
                        $jenis_laporan = 'Simpanan Sukarela';
                    }
                    $data['title'] = 'Laporan';
                    $data['sub_title'] = 'Laporan ' . $jenis_laporan;
                    $data['status'] = 'User';
                    $data['corp_name'] = 'Koperasi';
                    $data['kelompok'] = 'Kelompok 3';
                    $data['user'] = $this->app_models->getUserTable('user');
                    $data['userdata'] = $this->app_models->getUserTable('userdata');
                    $data['tanggal'] = new DateTime();


                    $data['simpanan'] = $this->print_models->getSimpanan($jenis_laporan);
                    $data['totalSimpanan'] = $this->print_models->getTotalSimpanan($jenis_laporan);

                    $this->load->view('templates/header', $data);
                    $this->load->view('templates/navbar', $data);
                    $this->load->view('templates/sidebar', $data);
                    $this->load->view('laporan/cekLaporanSimpanan', $data);
                    $this->load->view('templates/footer');
                }
            } else {
                $data['title'] = 'Laporan';
                $data['status'] = 'User';
                $data['corp_name'] = 'Koperasi';
                $data['kelompok'] = 'Kelompok 3';
                $data['user'] = $this->app_models->getUserTable('user');
                $data['userdata'] = $this->app_models->getUserTable('userdata');
                $data['tanggal'] = new DateTime();

                if ($jenis_laporan == 'pinjaman') {
                    $data['sub_title'] = 'Laporan Pinjaman';
                    $data['pinjaman'] = $this->print_models->getPinjamanByTanggal($tgl_awal, $tgl_akhir);
                    $data['totalPinjaman'] = $this->print_models->getTotalPinjamanByTanggal($tgl_awal, $tgl_akhir);
                    $data['totalBunga'] = $this->print_models->getBungaByTanggal($tgl_awal, $tgl_akhir);

                    if ($data['pinjaman'] == NULL) {
                        $this->session->set_flashdata('alert_message', '<div class="alert alert-danger alert-dismissible fade show"><strong>Gagal mencetak! </strong>Tidak ada data.</div>');
                        redirect('laporan');
                    } else {
                        $this->load->view('templates/header', $data);
                        $this->load->view('templates/navbar', $data);
                        $this->load->view('templates/sidebar', $data);
                        $this->load->view('laporan/cekLaporanPinjaman', $data);
                        $this->load->view('templates/footer');
                    }
                } else {
                    if ($jenis_laporan == 'simpananPokok') {
                        $jenis_laporan = 'Simpanan Pokok';
                    } elseif ($jenis_laporan == 'simpananWajib') {
                        $jenis_laporan = 'Simpanan Wajib';
                    } elseif ($jenis_laporan == 'simpananSukarela') {
                        $jenis_laporan = 'Simpanan Sukarela';
                    }

                    $data['simpanan'] = $this->print_models->getSimpananByTanggalAndJenis($tgl_awal, $tgl_akhir, $jenis_laporan);
                    $data['totalSimpanan'] = $this->print_models->getTotalSimpananByTanggalAndJenis($tgl_awal, $tgl_akhir, $jenis_laporan);

                    if ($data['simpanan'] == NULL) {
                        $this->session->set_flashdata('alert_message', '<div class="alert alert-danger alert-dismissible fade show"><strong>Gagal mencetak! </strong>Tidak ada data.</div>');
                        redirect('laporan');
                    } else {
                        $data['title'] = 'Laporan';
                        $data['sub_title'] = 'Laporan ' . $jenis_laporan;
                        $data['status'] = 'User';
                        $data['corp_name'] = 'Koperasi';
                        $data['kelompok'] = 'Kelompok 3';

                        $this->load->view('templates/header', $data);
                        $this->load->view('templates/navbar', $data);
                        $this->load->view('templates/sidebar', $data);
                        $this->load->view('laporan/cekLaporanSimpanan', $data);
                        $this->load->view('templates/footer');
                    }
                }
            }
        }
    }

    public function printPinjaman()
    {
        $data['title'] = 'Laporan';
        $data['corp_name'] = 'Koperasi';
        $data['user'] = $this->app_models->getUserTable('user');
        $data['userdata'] = $this->app_models->getUserTable('userdata');
        $data['tanggal'] = new DateTime();
        $data['pinjaman'] = $this->print_models->getPinjaman();
        $data['totalPinjaman'] = $this->print_models->getTotalPinjaman();
        $data['totalBunga'] = $this->print_models->getBunga();


        $this->load->view('templates/header', $data);
        $this->load->view('print/printPinjaman', $data);
    }

    public function printPinjamanExcel()
    {
        $data['title'] = 'Laporan';
        $data['corp_name'] = 'Koperasi';
        $data['user'] = $this->app_models->getUserTable('user');
        $data['userdata'] = $this->app_models->getUserTable('userdata');
        $data['tanggal'] = new DateTime();
        $data['pinjaman'] = $this->print_models->getPinjaman();
        $data['totalPinjaman'] = $this->print_models->getTotalPinjaman();
        $data['totalBunga'] = $this->print_models->getBunga();


        $this->load->view('templates/header', $data);
        $this->load->view('print/printPinjamanExcel', $data);
    }

    public function printSimpanan()
    {
        $data['title'] = 'Laporan';
        $data['corp_name'] = 'Koperasi';
        $data['user'] = $this->app_models->getUserTable('user');
        $data['userdata'] = $this->app_models->getUserTable('userdata');
        $data['tanggal'] = new DateTime();

        $jenis_simpanan = $this->session->flashdata('jenis_simpanan');
        if ($jenis_simpanan == 'simpananPokok') {
            $jenis_simpanan = 'Simpanan Pokok';
            $data['jenis'] = 'POKOK';
        } elseif ($jenis_simpanan == 'simpananWajib') {
            $jenis_simpanan = 'Simpanan Wajib';
            $data['jenis'] = 'WAJIB';
        } elseif ($jenis_simpanan == 'simpananSukarela') {
            $jenis_simpanan = 'Simpanan Sukarela';
            $data['jenis'] = 'SUKARELA';
        }

        $data['simpanan'] = $this->print_models->getSimpanan($jenis_simpanan);
        $data['totalSimpanan'] = $this->print_models->getTotalSimpanan($jenis_simpanan);


        $this->load->view('templates/header', $data);
        $this->load->view('print/printSimpanan', $data);
    }

    public function printSimpananExcel()
    {
        $data['title'] = 'Laporan';
        $data['corp_name'] = 'Koperasi';
        $data['user'] = $this->app_models->getUserTable('user');
        $data['userdata'] = $this->app_models->getUserTable('userdata');
        $data['tanggal'] = new DateTime();

        $jenis_simpanan = $this->session->flashdata('jenis_simpanan');
        if ($jenis_simpanan == 'simpananPokok') {
            $jenis_simpanan = 'Simpanan Pokok';
            $data['jenis'] = 'POKOK';
        } elseif ($jenis_simpanan == 'simpananWajib') {
            $jenis_simpanan = 'Simpanan Wajib';
            $data['jenis'] = 'WAJIB';
        } elseif ($jenis_simpanan == 'simpananSukarela') {
            $jenis_simpanan = 'Simpanan Sukarela';
            $data['jenis'] = 'SUKARELA';
        }

        $data['simpanan'] = $this->print_models->getSimpanan($jenis_simpanan);
        $data['totalSimpanan'] = $this->print_models->getTotalSimpanan($jenis_simpanan);


        $this->load->view('templates/header', $data);
        $this->load->view('print/printSimpananExcel', $data);
    }

    public function printTanggalAndJenis()
    {
        $data['title'] = 'Laporan';
        $data['corp_name'] = 'Koperasi';
        $data['user'] = $this->app_models->getUserTable('user');
        $data['userdata'] = $this->app_models->getUserTable('userdata');
        $data['tanggal'] = new DateTime();
        $filter = $this->session->flashdata('filter');
        $tgl_awal = $filter[0];
        $tgl_akhir = $filter[1];
        $jenis_laporan = $filter[2];

        if ($jenis_laporan == 'pinjaman') {
            $data['pinjaman'] = $this->print_models->getPinjamanByTanggal($tgl_awal, $tgl_akhir);
            $data['totalPinjaman'] = $this->print_models->getTotalPinjamanByTanggal($tgl_awal, $tgl_akhir);
            $data['totalBunga'] = $this->print_models->getBungaByTanggal($tgl_awal, $tgl_akhir);

            if ($data['pinjaman'] == NULL) {
                $this->session->set_flashdata('alert_message', '<div class="alert alert-danger alert-dismissible fade show"><strong>Gagal mencetak! </strong>Tidak ada data.</div>');
                redirect('laporan');
            } else {
                $this->load->view('templates/header', $data);
                $this->load->view('print/printPinjaman', $data);
            }
        } else {
            if ($jenis_laporan == 'simpananPokok') {
                $jenis_laporan = 'Simpanan Pokok';
                $data['jenis'] = 'POKOK';
            } elseif ($jenis_laporan == 'simpananWajib') {
                $jenis_laporan = 'Simpanan Wajib';
                $data['jenis'] = 'WAJIB';
            } elseif ($jenis_laporan == 'simpananSukarela') {
                $jenis_laporan = 'Simpanan Sukarela';
                $data['jenis'] = 'SUKARELA';
            }

            $data['simpanan'] = $this->print_models->getSimpananByTanggalAndJenis($tgl_awal, $tgl_akhir, $jenis_laporan);
            $data['totalSimpanan'] = $this->print_models->getTotalSimpananByTanggalAndJenis($tgl_awal, $tgl_akhir, $jenis_laporan);

            if ($data['simpanan'] == NULL) {
                $this->session->set_flashdata('alert_message', '<div class="alert alert-danger alert-dismissible fade show"><strong>Gagal mencetak! </strong>Tidak ada data.</div>');
                redirect('laporan');
            } else {
                $this->load->view('templates/header', $data);
                $this->load->view('print/printSimpanan', $data);
            }
        }
    }

    public function printTanggalAndJenisExcel()
    {
        $data['title'] = 'Laporan';
        $data['corp_name'] = 'Koperasi';
        $data['user'] = $this->app_models->getUserTable('user');
        $data['userdata'] = $this->app_models->getUserTable('userdata');
        $data['tanggal'] = new DateTime();
        $filter = $this->session->flashdata('filter');
        $tgl_awal = $filter[0];
        $tgl_akhir = $filter[1];
        $jenis_laporan = $filter[2];

        if ($jenis_laporan == 'pinjaman') {
            $data['pinjaman'] = $this->print_models->getPinjamanByTanggal($tgl_awal, $tgl_akhir);
            $data['totalPinjaman'] = $this->print_models->getTotalPinjamanByTanggal($tgl_awal, $tgl_akhir);
            $data['totalBunga'] = $this->print_models->getBungaByTanggal($tgl_awal, $tgl_akhir);

            if ($data['pinjaman'] == NULL) {
                $this->session->set_flashdata('alert_message', '<div class="alert alert-danger alert-dismissible fade show"><strong>Gagal mencetak! </strong>Tidak ada data.</div>');
                redirect('laporan');
            } else {
                $this->load->view('templates/header', $data);
                $this->load->view('print/printPinjamanExcel', $data);
            }
        } else {
            if ($jenis_laporan == 'simpananPokok') {
                $jenis_laporan = 'Simpanan Pokok';
                $data['jenis'] = 'POKOK';
            } elseif ($jenis_laporan == 'simpananWajib') {
                $jenis_laporan = 'Simpanan Wajib';
                $data['jenis'] = 'WAJIB';
            } elseif ($jenis_laporan == 'simpananSukarela') {
                $jenis_laporan = 'Simpanan Sukarela';
                $data['jenis'] = 'SUKARELA';
            }

            $data['jenis_laporan'] = $jenis_laporan;
            $data['simpanan'] = $this->print_models->getSimpananByTanggalAndJenis($tgl_awal, $tgl_akhir, $jenis_laporan);
            $data['totalSimpanan'] = $this->print_models->getTotalSimpananByTanggalAndJenis($tgl_awal, $tgl_akhir, $jenis_laporan);

            if ($data['simpanan'] == NULL) {
                $this->session->set_flashdata('alert_message', '<div class="alert alert-danger alert-dismissible fade show"><strong>Gagal mencetak! </strong>Tidak ada data.</div>');
                redirect('laporan');
            } else {
                $this->load->view('templates/header', $data);
                $this->load->view('print/printSimpananExcel', $data);
            }
        }
    }
}
