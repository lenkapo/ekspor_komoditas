<?php defined('BASEPATH') or exit('No direct script access allowed');

class Satuan extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model', 'Alus_items');
    }

    public function index()
    {
        if ($this->alus_auth->logged_in()) {
            $title_head = "Daftar Satuan";
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
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $person->s_satuan;
            $row[] = $person->nama_satuan;
            $row[] = date('d-m-Y H:i', strtotime($person->created_at));
            $row[] = $person->created_by;
            $row[] = date('d-m-Y H:i', strtotime($person->updated_at));
            $row[] = $person->edited_by;
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
        $data = array(
            's_satuan' => $this->input->post('s_satuan'),
            'nama_satuan' => $this->input->post('nama_satuan'),
            'created_by' => $this->get_current_user(),
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
