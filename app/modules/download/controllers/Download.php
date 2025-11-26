<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Download extends CI_Controller {
	

	public function __construct()
	{	
		parent::__construct();

	}

	public function url($urs=null,$namafile=NULL,$login=NULL)
	{
    $filename =null;
    if($urs == null)
    {
      echo "NOT ALLOWED";
      exit;

    }else{

      $urs = rawurldecode($urs);
      try {
        if($this->alus_auth->decrypt($urs)){
          $filename = $this->alus_auth->decrypt($urs);          
        }
      } catch (Exception $e) {
         echo "NOT ALLOWED";
         exit;
      }

    }

    if($login)
      {

        $login = rawurldecode($login);
        try {
          if($this->alus_auth->decrypt($login)){
            $login = $this->alus_auth->decrypt($login);          
          }
        } catch (Exception $e) {
           echo "NOT ALLOWED";
           exit;
        }

        $namafile = rawurldecode($namafile);
        try {
          if($this->alus_auth->decrypt($namafile)){
            $namafile = $this->alus_auth->decrypt($namafile);          
            
          }
        } catch (Exception $e) {
           echo "NOT ALLOWED";
           exit;
        }

        if($login == 'iya')
        {
            if(!$this->alus_auth->logged_in())
            {
               redirect('admin/Login','refresh');
            }else{
               /*SUDAH LOGIN*/
               if(file_exists($filename))
               {
                 if($namafile == 'tidak')
                 {
                   $this->force_download($filename,NULL); 
                 }else{
                   $this->force_download($filename,$namafile); 
                 }
               }else{
                 echo "FILE TIDAK DITEMUKAN";
                 exit;
               }
            }
        }else{
           /*TANPA LOGIN*/
         if(file_exists($filename))
            {
              if($namafile == 'tidak')
              {
                $this->force_download($filename,NULL); 
              }else{
                $this->force_download($filename,$namafile); 
              }
            }else{
              echo "FILE TIDAK DITEMUKAN";
              exit;
            }
          } 
      }else{
        echo "NOT ALLOWED !";
        exit;
      }
        
	}

private function force_download($filename,$rename) {
    $filedata = @file_get_contents($filename);

    // SUCCESS
    if ($filedata)
    {
        // GET A NAME FOR THE FILE
        $basename = basename($filename);

        // THESE HEADERS ARE USED ON ALL BROWSERS
        header("Content-Type: application-x/force-download");
        if($rename != NULL)
        {
          header("Content-Disposition: attachment; filename=$rename");          
        }else{
          header("Content-Disposition: attachment; filename=$basename");
        }
        header("Content-length: " . (string)(strlen($filedata)));
        header("Expires: ".gmdate("D, d M Y H:i:s", mktime(date("H")+2, date("i"), date("s"), date("m"), date("d"), date("Y")))." GMT");
        header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");

        // THIS HEADER MUST BE OMITTED FOR IE 6+
        if (FALSE === strpos($_SERVER["HTTP_USER_AGENT"], 'MSIE '))
        {
            header("Cache-Control: no-cache, must-revalidate");
        }

        // THIS IS THE LAST HEADER
        header("Pragma: no-cache");

        // FLUSH THE HEADERS TO THE BROWSER
        flush();

        // CAPTURE THE FILE IN THE OUTPUT BUFFERS - WILL BE FLUSHED AT SCRIPT END
        ob_start();
        echo $filedata;
    }

    // FAILURE
    else
    {
        die("ERROR: UNABLE TO OPEN $filename");
    }
}

}

/* End of file X.php */
/* Location: ./application/modules/X/controllers/X.php */