<?php 
set_time_limit(120);

$bulan 	= isset($_POST['bulan']) ? $_POST['bulan'] : '';
$tahun 	= isset($_POST['tahun']) ? $_POST['tahun'] : '';
$url 	= 'https://sites.google.com/macros/exec?service=AKfycbxoZDvBSaC2QRdzvoRlFzr6EzDLoimdqewnpeMoGoMFAT2sD3cB&tahun='.$tahun.'&bulan='.$bulan; 

$response = file_get_contents($url);

//Mengecek dulu response data
//Jika tidak ada response maka eksekusi script dihentikan dan menampilakn pesan tidak ada response
if(($response==null) || ($response=='')){
	exit("Tidak ada respnse");
}

$parsing = json_decode($response);

//Mengecek dulu status apakah sukses atau tidak
//Jika tidak sukses maka eksekusi script dihentikan dan menampilakn pesan data tidak dittemukan
if($parsing->status != 'success'){
	exit("Data tidak ditemukan");
}

//Jika status sukses dipastikan data ada dan siap untuk digunakan dan melanjutkan eksekusi script dibawahnya
$data 	= $parsing->data; //Mengambil value dengan key data (object)

?>

<center><table cellpadding="10" border="1" style="font-size:12px";>
	<thead>
		<tr>
			<?php 
				$prediksi = $data[0]->data;
				echo'<th>Nama Komoditas</th>
					<th>Unit / Satuan</th>';
					
				foreach($prediksi as $tgl){
					echo'<th>'.$tgl->tanggal.'-'.$bulan.'-'.$tahun.'</th>';
				}
			?>
		</tr>
	</thead>
	<tbody>
		<?php 
			foreach($data as $komoditas){
				echo'<tr>
						<th>'.$komoditas->komoditas.'</th>
						<td>'.$komoditas->unit.'</td>';
					foreach($komoditas->data as $perTgl){
						echo'<td> Rp. '.str_replace(",",".",$perTgl->harga).'</td>';
					}
				echo'</tr>';
			}
		?>
	</tbody>
<table></center>