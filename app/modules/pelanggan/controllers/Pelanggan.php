<?php defined('BASEPATH') or exit('No direct script access allowed');

class Pelanggan extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model', 'Alus_items');
    }

    public function index()
    {
        if ($this->alus_auth->logged_in()) {
            $title_head = "Data Pelanggan";
            $head['title'] = $title_head;
            $data['title_head'] = $title_head;
            $this->load->helper(array('url'));

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
            // $jenis = $this->db->where('id', $person->jenis_id)->get('jenis')->row();
            // // mendapatkan data Provinsi
            // $provinsi = $this->db->where('id', $person->province_id)->get('provinces')->row();
            // // mendapatkan data Kabupaten
            // $kabupaten = $this->db->where('id', $person->regency_id)->get('regencies')->row();


            $row = array();
            $row[] = $no;
            $row[] = $person->nama;
            $row[] = $person->jenis_kelamin;
            $row[] = $person->alamat;
            $row[] = $person->telepon;
            // // Menampilkan data Provinsi
            // if (isset($provinsi->name)) {
            //     $row[] = $provinsi->name;
            // } else {
            //     $row[] = "Deleted Data Jenis";
            // }
            // // Menampilkan data Kabupaten
            // if (isset($kabupaten->name)) {
            //     $row[] = $kabupaten->name;
            // } else {
            //     $row[] = "Deleted Data Jenis";
            // }


            // if (isset($jenis->nama_jenis)) {
            //     $row[] = $jenis->s_jenis;
            // } else {
            //     $row[] = "Deleted Data Jenis";
            // }


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
        $data['title'] = "Tambah Data Pelanggan";
        $data['provinsi'] = $this->Alus_items->provinsi();
        $this->load->view('ajax/modal_add', $data, FALSE);
    }

    function modal_edit($id)
    {

        $data['data'] = $this->Alus_items->getid($id);
        $data['title'] = "Edit Data Pelanggan";
        $this->load->view('ajax/modal_edit', $data, FALSE);
    }

    /*ACTION*/

    function save()
    {
        $data = array(
            'id' => $this->input->post('id'),
            'nama' => $this->input->post('nama'),
            'jenis_kelamin' => $this->input->post('jenis_kelamin'),
            'alamat' => $this->input->post('alamat'),
            'telepon' => $this->input->post('telepon'),
            'jenis_id' => $this->input->post('jenis_id'),

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
            'id' => $this->input->post('id'),
            'nama' => $this->input->post('nama'),
            'jenis_kelamin' => $this->input->post('jenis_kelamin'),
            'alamat' => $this->input->post('alamat'),
            'telepon' => $this->input->post('telepon'),
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

    function ambil_data()
    {
        $id = $this->input->post('id');
        $modul = $this->input->post('modul');

        if ($modul == "kabupaten") {
            echo $this->Alus_items->kabupaten($id);
        } else if ($modul == "kecamatan") {
            echo $this->Alus_items->kecamatan($id);
        } else if ($modul == "kelurahan") {
            echo $this->Alus_items->kelurahan($id);
        }
    }
}
