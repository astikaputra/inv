public function cetak(){
//public function kartuanggota()
//$this->load->library('parser');

//$this->load->library('session');
//$session = $this->session->userdata('module');
{
$html = "<style type="text/css">
body{
font-family: tahoma;
font-size: 1px;
}
h3{
font-family: tahoma;
font-size: 20px;
}
td{
font-family: arial;
font-size: 12px;
}
.title{
font-family: arial;
font-size: 10px;
}
</style>
<table align="center" cellpadding="0" cellspacing="0" border="1" width="350px">
<tr>
<td width="100%">
<table align="center" cellpadding="0" cellspacing="0" border="0" width="330">
<tr>
<td>{foto}</td>
<td align="center" class="title">
<h3 class="" style="margin-top: 0px; margin-bottom: 0px;">KARTU ANGGOTA</h3>
SMA Negeri 10 <br/>
Jalan Cikutra No 77 Bandung 40291 <br/>
Telp. 02196021696
</td>
</tr>
<tr><td colspan="2"><hr/></td></tr>
<tr>
<td colspan="2">
<table>
<tr><td>NIS</td><td>:</td><td>".$nis."</td></tr>
<tr><td>NAMA</td><td>:</td><td>{nama}</td></tr>
<tr><td>KELAS</td><td>:</td><td>{kelas}</td></tr>
<tr><td>TANGGAL DAFTAR</td><td>:</td><td>{tanggal daftar}</td></tr>
<tr><td>TANGGAL EXPIRED</td><td>:</td><td>{tanggal daftar}</td></tr>
</table>
</td>
</tr>
</table>
</td>
</tr>
</table>";
/* ============================================= */

$this->load->library('mpdf');
$this->mpdf->WriteHTML($html);
$this->mpdf->Output();
$this->load->view('system',$data);


}
}



