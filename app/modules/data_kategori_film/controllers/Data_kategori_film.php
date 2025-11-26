<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @author      Maulana Rahman <maulana.code@gmail.com>
 */

class Data_kategori_film extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model', 'Alus_items');
    }

    public function index()
    {
        if ($this->alus_auth->logged_in()) {
            $title_head = "Kategori Film";
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
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $person->name;
            $row[] = $person->description;
            $row[] = '<img src="' . base_url('assets/categories/') . $person->picture . '" width="200px" height="auto">';
            if ($person->is_active) {
                $row[] = "<span class='label label-success'>Active</span>";
            } else {
                $row[] = "<span class='label label-danger'>Not Active</span>";
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
        $data['title'] = "Tambah Kategori Film";
        $this->load->view('ajax/modal_add', FALSE);
    }

    function modal_edit($id)
    {
        $data['data'] = $this->Alus_items->getid($id);
        $data['title'] = "Edit Kategori Film";
        $this->load->view('ajax/modal_edit', $data, FALSE);
    }

    /*ACTION*/

    function save()
    {
        $data = array(
            'name' => $this->input->post('name'),
            'description' => $this->input->post('description'),
            'is_active' => $this->input->post('is_active'),
            'created_by_user_id' => $this->session->userdata('id'),
        );

        if ($_FILES['userfile']['name'] != '') {
            //--upload
            $upload = $this->_do_upload('userfile');
            $m_file = $upload;
        }

        if ($_FILES['userfile']['name'] != '') {
            $data['picture'] = $m_file;
        }


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
            'name' => $this->input->post('name'),
            'description' => $this->input->post('description'),
            'is_active' => $this->input->post('is_active'),
        );

        if ($_FILES['userfile']['name'] != '') {
            /*cek jika file lama ada, maka hapus */
            if ($this->input->post('userfile_lama') != "") {
                if (file_exists('./assets/categories/' . $this->input->post('userfile_lama'))) {
                    unlink('assets/categories/' . $this->input->post('userfile_lama'));
                }
            }
            /*cek*/

            //--upload
            $upload = $this->_do_upload('userfile');
            $m_file = $upload;
            $m_file_name_asli = $_FILES['userfile']['name'];

            $data['picture'] = $m_file;
        }

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
        $this->db->where('id', $id);
        $dt_lama = $this->db->get('categories');

        if ($dt_lama->num_rows() > 0) {
            if (file_exists('./assets/categories/' . $dt_lama->row()->picture)) {
                unlink('assets/categories/' . $dt_lama->row()->picture);
            }
        }

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

    private function _do_upload($key)
    {
        $config['upload_path']          = './assets/categories';
        $config['allowed_types']        = 'jpg|png|jpeg|bmp|gif';
        $config['max_size']             = 10000; //set max size allowed in Kilobyte
        $config['file_name']            = round(microtime(true) * 100); //just milisecond timestamp fot unique name

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload($key)) //upload and validate
        {
            echo json_encode(array("status" => FALSE, "msg" => $this->upload->display_errors('', '')));

            exit();
        } else {
            $gbr = $this->upload->data();
            //Compress Image
            $config['image_library'] = 'gd2';
            $config['source_image'] = './assets/categories/' . $gbr['file_name'];
            $config['create_thumb'] = FALSE;
            $config['maintain_ratio'] = FALSE;
            $config['quality'] = '100%';
            $config['width'] = 414;
            $config['height'] = 280;
            $config['new_image'] = './assets/categories/' . $gbr['file_name'];
            $this->load->library('image_lib', $config);
            $this->image_lib->resize();
            return $gbr['file_name'];
        }
    }
}

/* Location: ./application/modules/X/controllers/X.php */
/* End of file X.php */