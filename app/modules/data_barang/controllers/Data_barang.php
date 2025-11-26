<?php defined('BASEPATH') or exit('No direct script access allowed');

class Data_barang extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model', 'Alus_items');
    }

    public function index()
    {
        if ($this->alus_auth->logged_in()) {
            $title_head = "Data Barang";
            $head['title'] = $title_head;
            $data['title_head'] = $title_head;

            $this->load->view('template/temaalus/header', $head);
            $this->load->view('index', $data);
            $this->load->view('template/temaalus/footer');
        } else {
            redirect('admin/login', 'refresh');
        }
    }
    /*AJAX LIST*/

    public function ajax_list()
    {
        $list = $this->Alus_items->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $person) {
            $jenis = $this->db->where('id', $person->jenis_id)->get('jenis')->row();
            $satuan = $this->db->where('id', $person->satuan_id)->get('satuan')->row();
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $person->id_barang;
            $row[] = $person->nama_barang;
            // Menampilkan Data Jenis
            if (isset($jenis->nama_jenis)) {
                $row[] = $jenis->nama_jenis;
            } else {
                $row[] = "Deleted Data Jenis";
            }
            $row[] = $person->stok;
            // Menampilkan Data Satuan
            if (isset($satuan->nama_satuan)) {
                $row[] = $satuan->nama_satuan;
            } else {
                $row[] = "Deleted Data Satuan";
            }
            $row[] = "<a href='javascript:' onClick='btn_modal_edit(" . $person->id . ")' data-toggle='tooltip' data-placement='bottom' title='Edit' class='btn btn-xs btn-flat btn-primary' style='background:#00897b'><i class='fa fa-edit'></i> Edit</a>" . "<a href='javascript:' onClick='btn_modal_delete(" . $person->id . ")' data-toggle='tooltip' data-placement='bottom' title='Delete' class='btn btn-xs btn-flat btn-danger'><i class='fa fa-trash'></i> Delete</a>";
            //add html for action
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Alus_items->count_all(),
            "recordsFiltered" => $this->Alus_items->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    function modal_add()
    {
        $data['title'] = "Tambah Daftar Satuan";
        // Mengenerate ID Barang
        $data['id_barang'] = $this->Alus_items->generate_id_barang();
        $this->load->view('ajax/modal_add', $data, FALSE);
    }

    function modal_edit($id)
    {

        $data['data'] = $this->Alus_items->getid($id);
        $data['title'] = "Edit Daftar Satuan";
        $this->load->view('ajax/modal_edit', $data, FALSE);
    }

    /*ACTION*/

    function save()
    {
        // Generate ID barang baru
        $id_baru = $this->Alus_items->generate_id_barang();

        $data = array(
            'id_barang' => $id_baru,
            'nama_barang' => $this->input->post('nama_barang'),
            'satuan_id' => $this->input->post('satuan_id'),
            'jenis_id' => $this->input->post('jenis_id'),
            'stok' => $this->input->post('stok'),
        );

        $q = $this->Alus_items->save($data);
        if ($q) {
            $output = array(
                "status" => true,
                "message" => "Berhasil",
            );
        } else {
            $output = array(
                "status" => false,
                "message" => "Gagal Simpan",
            );
        }

        //output to json format
        echo json_encode($output);
    }

    function edit()
    {
        $data = array(
            's_satuan' => $this->input->post('s_satuan'),
            'nama_satuan' => $this->input->post('nama_satuan'),
            'edited_by' => $this->get_current_user(),
        );
        $q = $this->Alus_items->edit($data);
        if ($q) {
            $output = array(
                "status" => true,
                "message" => "Berhasil",
            );
        } else {
            $output = array(
                "status" => false,
                "message" => "Gagal Simpan",
            );
        }

        //output to json format
        echo json_encode($output);
    }

    function delete($id)
    {
        $q = $this->Alus_items->delete($id);
        if ($q) {
            $output = array(
                "status" => true,
                "message" => "Berhasil",
            );
        } else {
            $output = array(
                "status" => false,
                "message" => "Gagal",
            );
        }

        //output to json format
        echo json_encode($output);
    }

    private function get_current_user()
    {
        // Logika untuk mendapatkan user dari session
        // Ganti 'username' dengan key session Anda yang sesuai
        $username = $this->session->userdata('username');
        return $username;
    }
}
