<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @author      Maulana Rahman <maulana.code@gmail.com>
 */

class Data_reviews extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model', 'Alus_items');
    }

    public function index()
    {
        if ($this->alus_auth->logged_in()) {
            $title_head = "Review Film";
            $head['title'] = $title_head;
            $data['title_head'] = $title_head;

            /*DATA*/

            /*END DATA*/

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
            $film = $this->db->where('id',$person->movie_id)->get('movies')->row();
            $no++;
            $row = array();
            $row[] = $no;
            if(isset($film->title)) {
                $row[] = $film->title;
            } else {
                $row[] = "Deleted Movie";
            }
            $row[] = $person->name;
            $row[] = $person->title;
            $row[] = $person->review;
            $row[] = $person->rating;
            $row[] = date('d-m-Y H:i',strtotime($person->created_at));
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
        $data['title'] = "Tambah Review Film";
        $this->load->view('ajax/modal_add', FALSE);
    }

    function modal_edit($id)
    {
        $data['data'] = $this->Alus_items->getid($id);
        $data['title'] = "Edit Review Film";
        $this->load->view('ajax/modal_edit', $data, FALSE);
    }

    /*ACTION*/

    function save()
    {
        $data = array(
            'movie_id' => $this->input->post('movie_id'),
            'name' => $this->input->post('name'),
            'title' => $this->input->post('title'),
            'review' => $this->input->post('review'),
            'rating' => $this->input->post('rating'),
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
            'movie_id' => $this->input->post('movie_id'),
            'name' => $this->input->post('name'),
            'title' => $this->input->post('title'),
            'review' => $this->input->post('review'),
            'rating' => $this->input->post('rating'),
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
}

/* Location: ./application/modules/X/controllers/X.php */
/* End of file X.php */