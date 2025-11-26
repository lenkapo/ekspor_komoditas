<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @author      Maulana Rahman <maulana.code@gmail.com>
 */

class Data_film extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model', 'Alus_items');
    }

    public function index()
    {
        if ($this->alus_auth->logged_in()) {
            $title_head = "Data Film";
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
            $row[] = '<img src="' . base_url('assets/movies/') . $person->picture . '" width="200px" height="auto">';
            $row[] = $person->title;
            $row[] = $person->year;
            $row[] = $person->description;
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
        $data['title'] = "Tambah Data Film";
        $this->load->view('ajax/modal_add', FALSE);
    }

    function modal_edit($id)
    {
        $data['data'] = $this->Alus_items->getid($id);
        $data['title'] = "Edit Data Film";
        $this->load->view('ajax/modal_edit', $data, FALSE);
    }

    /*ACTION*/

    function save()
    {
        $data = array(
            'title' => $this->input->post('title'),
            'rating' => $this->input->post('rating'),
            'is_featured' => $this->input->post('featured'),
            'year' => $this->input->post('year'),
            'duration' => $this->input->post('duration'),
            'age' => $this->input->post('age'),
            'description' => $this->input->post('description'),
            'link_trailer' => $this->input->post('link_trailer'),
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

        if ($_FILES['movie']['name'] != '') {
            //--upload
            $upload = $this->_do_upload_movie('movie');
            $m_file = $upload;
        }

        if ($_FILES['movie']['name'] != '') {
            $data['file_movie'] = $m_file;
        }


        $q = $this->Alus_items->save($data);
        if (count($this->input->post('categories[]')) > 0) {
            foreach ($this->input->post('categories[]') as $key => $value) {
                $inp = array(
                    'movie_id' => $q,
                    'category_id' => $value,
                );
                $this->db->insert('movie_categories', $inp);
            }
        }
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
            'title' => $this->input->post('title'),
            'rating' => $this->input->post('rating'),
            'is_featured' => $this->input->post('featured'),
            'year' => $this->input->post('year'),
            'duration' => $this->input->post('duration'),
            'age' => $this->input->post('age'),
            'description' => $this->input->post('description'),
            'link_trailer' => $this->input->post('link_trailer'),
            'created_by_user_id' => $this->session->userdata('id'),
        );

        if ($_FILES['userfile']['name'] != '') {
            /*cek jika file lama ada, maka hapus */
            if ($this->input->post('userfile_lama') != "") {
                if (file_exists('./assets/movies/' . $this->input->post('userfile_lama'))) {
                    unlink('assets/movies/' . $this->input->post('userfile_lama'));
                }
            }
            /*cek*/

            //--upload
            $upload = $this->_do_upload('userfile');
            $m_file = $upload;

            $data['picture'] = $m_file;
        }

        if ($_FILES['movie']['name'] != '') {
            /*cek jika file lama ada, maka hapus */
            if ($this->input->post('movie_lama') != "") {
                if (file_exists('./assets/movies/' . $this->input->post('movie_lama'))) {
                    unlink('assets/movies/' . $this->input->post('movie_lama'));
                }
            }
            /*cek*/

            //--upload
            $upload = $this->_do_upload_movie('movie');
            $m_file = $upload;

            $data['file_movie'] = $m_file;
        }

        $q = $this->Alus_items->edit($data);
        if (count($this->input->post('categories[]')) > 0) {
            $this->db->where('movie_id', $this->input->post('id'));
            $this->db->delete('movie_categories');

            foreach ($this->input->post('categories[]') as $key => $value) {
                $inp = array(
                    'movie_id' => $this->input->post('id'),
                    'category_id' => $value,
                );
                $this->db->insert('movie_categories', $inp);
            }
        }
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
            if (file_exists('./assets/movies/' . $dt_lama->row()->picture)) {
                unlink('assets/movies/' . $dt_lama->row()->picture);
            }

            if (file_exists('./assets/movies/' . $dt_lama->row()->file_movie)) {
                unlink('assets/movies/' . $dt_lama->row()->file_movie);
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
        $config['upload_path']          = './assets/movies';
        $config['allowed_types']        = '*';
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
            $config['source_image'] = './assets/movies/' . $gbr['file_name'];
            $config['create_thumb'] = FALSE;
            $config['maintain_ratio'] = FALSE;
            $config['quality'] = '100%';
            $config['width'] = 400;
            $config['height'] = 600;
            $config['new_image'] = './assets/movies/' . $gbr['file_name'];
            $this->load->library('image_lib', $config);
            $this->image_lib->resize();
            return $gbr['file_name'];
        }
    }

    private function _do_upload_movie($key)
    {
        $config['upload_path']          = './assets/movies';
        $config['allowed_types']        = '*';
        $config['max_size']             = 100000000000; //set max size allowed in Kilobyte
        $config['file_name']            = "movie_" . round(microtime(true) * 100); //just milisecond timestamp fot unique name

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload($key)) //upload and validate
        {
            echo json_encode(array("status" => FALSE, "msg" => $this->upload->display_errors('', '')));

            exit();
        } else {
            $gbr = $this->upload->data();
            return $gbr['file_name'];
        }
    }
}

/* Location: ./application/modules/X/controllers/X.php */
/* End of file X.php */
