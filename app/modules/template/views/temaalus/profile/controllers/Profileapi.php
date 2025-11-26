<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @author 		Oky Octaviansyah <oky.octaviansyah@yahoo.co.id>
*/

class Profileapi extends CI_Controller {
	
	

	public function __construct()
	{	
		parent::__construct();
		$this->load->model('Alus_items');
	}

	public function index()
	{
		if($this->alus_auth->logged_in())
         {
         	$title_head = "Profile";
         	$head['title'] = $title_head;
         	$data['title_head'] = $title_head;

         	/*DATA*/

         	/*END DATA*/

		 	$this->load->view('template/temaalus/header',$head);
		 	$this->load->view('index',$data);
		 	$this->load->view('template/temaalus/footer');
		}else
		{
			redirect('admin/Login','refresh');
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
            $row[] = $person->str;
            $row[] = $person->nama;
            $row[] = $person->tempat_lahir;
            $row[] = $person->tanggal_lahir;
            $row[] = $person->Apoteker;
            $row[] = $person->kelamin;
            $row[] = $person->universitas;
            $row[] = $person->tanggal_stra;
            $row[] = $person->tanggal_berlaku;
            $row[] = $person->tanggal_berakhir;
 			
            if($person->type==1){
        	   $row[] = "<a href='javascript:' onClick='btn_modal_edit(".$person->str.")' data-toggle='tooltip' data-placement='bottom' title='Edit' class='btn btn-xs btn-flat btn-primary' style='background:#00897b'><i class='fa fa-edit'></i> Edit</a>".
        			 "<a href='javascript:' onClick='btn_modal_delete(".$person->str.")' data-toggle='tooltip' data-placement='bottom' title='Delete' class='btn btn-xs btn-flat btn-danger'><i class='fa fa-trash'></i> Delete</a>";
        	}
            else
            {
                $row[] = "<a href='javascript:' data-toggle='tooltip' data-placement='bottom' title='Edit' class='btn btn-xs btn-flat btn-primary' style='background:#00897b' disabled> API</a>";
            }
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

    /*MODAL*/

    function modal_add()
    {
    	$data['title'] = "Add Kabupaten/Kota";
    	$this->load->view('ajax/modal_add', $data, FALSE);
    }

    function modal_edit($id)
    {
    	$data['data'] = $this->Alus_items->getid($id);
    	$data['title'] = "Edit Kabupaten/Kota";
    	$this->load->view('ajax/modal_edit', $data, FALSE);
    }

    /*ACTION*/

    function save()
    {
    	$data = array(
                        'Kabupaten/Kota' => $this->input->post('Kabupaten/Kota'),
                        'Kabupaten/Kota_id' => $this->input->post('Kabupaten/Kota_id'),
                        'kabkota' => $this->input->post('kabkota'),
                        'kota_id' => $this->input->post('kota_id'),
                        'nama' => $this->input->post('nama'),
                        'noizin' => $this->input->post('noizin'),
                        'tglnoizin' => $this->input->post('tglnoizin'),
                        'klproduk' => $this->input->post('klproduk'),
                        'alamat' => $this->input->post('alamat'),
                        'telp' => $this->input->post('telp'),
                        'namapimpinan' => $this->input->post('namapimpinan'),
                        'pjawab' => $this->input->post('pjawab'),
                        'jk' => $this->input->post('jk'),
                        'pend_pjawab' => $this->input->post('pend_pjawab'),
                        'sert_pjawab' => $this->input->post('sert_pjawab'),
                        'tutup' => $this->input->post('tutup'),
                        'tahun' => $this->input->post('tahun'),
                        'image1' => $this->input->post('image1'),
                        'image2' => $this->input->post('image2'),
                        'image3' => $this->input->post('image3'),
                        'image4' => $this->input->post('image4'),
                        'root_id' => $this->input->post('root_id'),
                        'audit_status' => $this->input->post('audit_status'),
                        'audit_user' => $this->input->post('audit_user'),
                        'audit_time' => $this->input->post('audit_time'),
                        'audit_approve' => $this->input->post('audit_approve'),
                        'audit_approve_user' => $this->input->post('audit_approve_user'),
                        'audit_approve_kota' => $this->input->post('audit_approve_kota'),
                        'audit_approve_kota_user' => $this->input->post('audit_approve_kota_user'),
                        'audit_approve_Kabupaten/Kota' => $this->input->post('audit_approve_Kabupaten/Kota'),
                        'audit_approve_Kabupaten/Kota_user' => $this->input->post('audit_approve_Kabupaten/Kota_user'),
                        'nik_penanggung_jawab' => $this->input->post('nik_penanggung_jawab'),
                        'npwp' => $this->input->post('npwp'),
                        'kode_pos_kantor' => $this->input->post('kode_pos_kantor'),
                        'kode_Kabupaten/Kota' => $this->input->post('kode_Kabupaten/Kota'),
                        'kode_kabkota' => $this->input->post('kode_kabkota'),
                        'tag_alamat_cabangpak' => $this->input->post('tag_alamat_cabangpak'),
                        'latitude' => $this->input->post('latitude'),
                        'longitude' => $this->input->post('longitude'),
                        'kode_kecamatan' => $this->input->post('kode_kecamatan'),
                        'kode_kelurahan' => $this->input->post('kode_kelurahan')
    				 );

    	$q = $this->Alus_items->save($data);
    	if($q)
    	{
    		echo "Tersimpan";
    	}
    	else
    	{
    		echo "Tidak Tersimpan";
    	}
    }

    function edit()
    {
    	$data = array(
					    'Kabupaten/Kota' => $this->input->post('Kabupaten/Kota'),
                        'Kabupaten/Kota_id' => $this->input->post('Kabupaten/Kota_id'),
                        'kabkota' => $this->input->post('kabkota'),
                        'kota_id' => $this->input->post('kota_id'),
                        'nama' => $this->input->post('nama'),
                        'noizin' => $this->input->post('noizin'),
                        'tglnoizin' => $this->input->post('tglnoizin'),
                        'klproduk' => $this->input->post('klproduk'),
                        'alamat' => $this->input->post('alamat'),
                        'telp' => $this->input->post('telp'),
                        'namapimpinan' => $this->input->post('namapimpinan'),
                        'pjawab' => $this->input->post('pjawab'),
                        'jk' => $this->input->post('jk'),
                        'pend_pjawab' => $this->input->post('pend_pjawab'),
                        'sert_pjawab' => $this->input->post('sert_pjawab'),
                        'tutup' => $this->input->post('tutup'),
                        'tahun' => $this->input->post('tahun'),
                        'image1' => $this->input->post('image1'),
                        'image2' => $this->input->post('image2'),
                        'image3' => $this->input->post('image3'),
                        'image4' => $this->input->post('image4'),
                        'root_id' => $this->input->post('root_id'),
                        'audit_status' => $this->input->post('audit_status'),
                        'audit_user' => $this->input->post('audit_user'),
                        'audit_time' => $this->input->post('audit_time'),
                        'audit_approve' => $this->input->post('audit_approve'),
                        'audit_approve_user' => $this->input->post('audit_approve_user'),
                        'audit_approve_kota' => $this->input->post('audit_approve_kota'),
                        'audit_approve_kota_user' => $this->input->post('audit_approve_kota_user'),
                        'audit_approve_Kabupaten/Kota' => $this->input->post('audit_approve_Kabupaten/Kota'),
                        'audit_approve_Kabupaten/Kota_user' => $this->input->post('audit_approve_Kabupaten/Kota_user'),
                        'nik_penanggung_jawab' => $this->input->post('nik_penanggung_jawab'),
                        'npwp' => $this->input->post('npwp'),
                        'kode_pos_kantor' => $this->input->post('kode_pos_kantor'),
                        'kode_Kabupaten/Kota' => $this->input->post('kode_Kabupaten/Kota'),
                        'kode_kabkota' => $this->input->post('kode_kabkota'),
                        'tag_alamat_cabangpak' => $this->input->post('tag_alamat_cabangpak'),
                        'latitude' => $this->input->post('latitude'),
                        'longitude' => $this->input->post('longitude'),
                        'kode_kecamatan' => $this->input->post('kode_kecamatan'),
                        'kode_kelurahan' => $this->input->post('kode_kelurahan')
    				 );

    	$q = $this->Alus_items->edit($data);
    	if($q)
    	{
    		echo "Tersimpan";
    	}
    	else
    	{
    		echo "Tidak Tersimpan";
    	}
    }

    function delete($id)
    {
    	$q = $this->Alus_items->delete($id);
    	if($q)
    	{
    		echo "Terhapus";
    	}
    	else
    	{
    		echo "Tidak Terhapus";
    	}
    }

    function cleandb()
    {
       return $this->db->truncate('straprofile_api'); 
    }

    function sycndb()
    {
                //$total = json_decode(file_get_contents("http://simada.bitcomz.com/api/getTable?username=kemenkes_kfn&token=WGERDA2108FCF4726730CFA628D5D3FB3F9494B441412CAN&nama_table=ref_kecamatan&per_page=LIMIT%2010"));
                $this->cleandb();
                $gettoken = json_decode(file_get_contents("http://stra.kemkes.go.id/api/token?&username=jabfung&password=zhYq3Px8"));
                $file = $gettoken->data;
                //print_r($file->token);
                $tokenaseli = $file->token;

                $totaljumlah = 1/1000;
                $putaran = ceil($totaljumlah);
                
                /*for ($i=0; $i < 1; $i++) {
                    $pageawal = $i * 1000;*/
                    $list = json_decode(file_get_contents("http://stra.kemkes.go.id/api/profile?username=jabfung&token=".$tokenaseli.""));
                    $dataku = $list->data;
                    foreach ($dataku as $key => $value) {
                        $data[] = array(
                                'str' => $dataku->str,
                                'nama' => $dataku->nama,
                                'tempat_lahir' => $dataku->tempat_lahir,
                                'tanggal_lahir' => $dataku->tanggal_lahir,
                                'Apoteker' => $dataku->Apoteker,
                                'kelamin' => $dataku->kelamin,
                                'universitas' => $dataku->universitas,
                                'tanggal_stra' => $dataku->tanggal_stra,
                                'tanggal_berlaku' => $dataku->tanggal_berlaku,
                                'tanggal_berakhir' => $dataku->tanggal_berakhir
                            );
                    }

                   
                    //unset($data);

               // }

                 $q = $this->db->insert_batch('straprofile_api', $data);
                
               if($q)
                {
                    echo "Data Telah Sync";
                }
                else
                {
                    echo "GAGAL SYNC";
                }


    }

}

/* End of file X.php */
/* Location: ./application/modules/X/controllers/X.php */