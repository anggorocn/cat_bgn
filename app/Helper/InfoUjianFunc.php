<?php
namespace App\Helper;
use Illuminate\Support\Str;

class InfoUjianFunc
{


public static function setinfo($kondisi="",$urutan="")
{
	$judul='<div class="judul"><h3><b>Ujian '.$urutan.'</b></h3></div>';

	if($kondisi == 8)
	{
		$statement= '
		<div class="area-instruksi">'.$judul.'
			<div class="keterangan">
			<p>Lihatlah gambar-gambar pada contoh pada tes ini. Kita lihat contoh pada baris pertama. Disitu Anda lihat bagaimana ranting pohon condong merebah, bagaikan tertiup angin. Mulai gambar di kotak pertama sampai pada kotak ketiga.</p>
			
			<span><img src="../../images/intruksi/a_subtes1_contoh1.jpg"></span>
			
			<p>Dapatkah Anda memilih 1 (satu) kotak selanjutnya diantara 6 (enam) kotak yang telah tersedia?</p>
			
			<p>Kotak <b>"c"</b> adalah yang tepat untuk gambar ranting yang rendah selanjutnya. Maka pilihlah <b>"c"</b> untuk jawaban Anda.</p>
			 
			<p>Sekarang lihatlah contoh kedua. Lihatlah bagian yang hitam, makin lama makin turun ke bawah. Seolah-olah itu sebuah tirai yang diturunkan dari atas ke bawah. Tentunya Anda tahu gambar yang tepat untuk mengisi kotak selanjutnya?</p>
			
			<span><img src="../../images/intruksi/a_subtes1_contoh2.jpg"></span>
			
			<p>Kotak <b>"e"</b> adalah yang tepat untuk gambar selanjutnya, maka pilihlah jawaban <b>"e"</b>.</p>
			
			<p>Sekarang kita beralih pada contoh ketiga. Lihatlah gambar-gambar kelopak daun bunga itu. Makin lama makin merekah bertambah satu helai daun, dimulai dari atas terus ke kanan. Nah, bagaimanakah Anda mengisi kelanjutan dari gambar-gambar tersebut? Coba cari kotak mana yang paling tepat?</p>
			
			<span><img src="../../images/intruksi/a_subtes1_contoh3.jpg"></span>
			
			<p>Kotak <b>"e"</b> adalah yang tepat untuk gambar selanjutnya.</p>
			
			<p>Mulailah dari no. 1 – 13. <b>Waktu anda terbatas, bekerjalah dengan cepat, teliti dan tepat.</b></p>
			
			<input type="button" value="OK" onclick="setBacaTipeUjian('.$kondisi.')" id="fvpp-close" style="display:none">
			
			</div>

		</div>
		';
	}
	elseif($kondisi == 9)
	{
		$statement= '
		<div class="area-instruksi">'.$judul.'
			<div class="keterangan">
			<p>Lihatlah gambar-gambar contoh pada baris pertama. Disitu ada 3 (tiga) kotak yang mempunyai bentuk gambar yang sama, tetapi 2 (dua) kotak lain yang mempunyai bentuk gambar yang berbeda.Tugas Anda adalah mencari pada setiap baris soal, 2 kotak yang gambarnya berbeda dengan gambar 3 kotak lainnya. Apabila Anda telah menemukan 2 kotak yang berbeda tersebut, maka pilihlah 2 (dua) huruf jawaban yang mewakili kotak tersebut.</p>
			<p>Pada gambar di garis pertama, Anda melihat ada 3 (tiga) kotak yang gambarnya <i>segitiga</i> dan 2 (dua) kotak yang gambarnya <i>segiempat</i>. Jadi, 2 kotak yang gambarnya <b>segiempat</b> itulah jawabannya.</p>
			
			<span><img src="../../images/intruksi/a_subtes2_contoh1.jpg"></span>
			
			<p>Kedua gambar itu berada di kotak dengan huruf <b>"b"</b> dan <b>"d"</b>. Maka Anda harus memilih jawaban <b>"b"</b> dan <b>"d"</b>.</p>
			 							
			<p>Sekarang lihatlah contoh pada baris kedua. Carilah 2 (dua) gambar yang berbeda dengan 3 (tiga) gambar lainnya.</p>
			
			<span><img src="../../images/intruksi/a_subtes2_contoh2.jpg"></span>
			
			<p>Jawabannnya adalah <b>"c"</b> dan <b>"e"</b>.</p>
			
			<p>Sekali lagi, tugas Anda adalah memilih 2 kotak atau 2 gambar yang berbeda dengan gambar-gambar yang lainnya pada setiap baris soal. Jadi, Anda harus memilih 2 jawaban.</p>
			  
			
			<p><b>Waktu anda terbatas, bekerjalah dengan cepat, teliti dan tepat.</b></p>
			
			<input type="button" value="OK" onclick="setBacaTipeUjian('.$kondisi.')" id="fvpp-close" style="display:none">
			
			</div>

		</div>
		';
	}
	elseif($kondisi == 10)
	{
		$statement= '
		<div class="area-instruksi">'.$judul.'
			
			<div class="keterangan">
			<p>Perhatikan gambar-gambar contoh pada tes 3 ini. Di dalam kotak yang besar, ada 4 kotak yang kecil. Tiga dari kotak-kotak kecil itu bergambar, tetapi ada 1 kotak kecil yang hilang. Kotak yang hilang ini terletak di antara 6 kotak kecil yang berada di sebelah kanan. Pilihlah salah satu.</p>
			
			<span><img src="../../images/intruksi/a_subtes3_contoh1.jpg"></span>
			
			<p>Dapatkah Anda memilih 1 (satu) kotak selanjutnya diantara 6 (enam) kotak yang telah tersedia?</p>
			
			<p>Perhatikan, kotak kedua lah yang tepat untuk mengisi kotak yang kosong itu. Kotak kedua ini terletak pada huruf <b>"b"</b>. Maka pilihlah jawaban <b>"b"</b>.</p>
			 
			<p>Sekarang lihatlah contoh kedua. Manakah jawaban yang benar?</p>
			
			<span><img src="../../images/intruksi/a_subtes3_contoh2.jpg"></span>
			
			<p>Kotak yang terletak pada huruf <b>"c"</b> yang tepat untuk mengisi kotak kecil yang hilang tersebut, karena yang hilang itu adalah gambar <b>ayam berbintik</b> yang menghadap ke kanan. Maka pilihlah jawaban sesuai dengan yang Anda anggap benar tersebut.</p>
			
			<p>Sekarang perhatikan kotak ketiga. Ada berapakah lingkaran yang Anda lihat?</p>
			
			<span><img src="../../images/intruksi/a_subtes3_contoh3.jpg"></span>
			
			<p>Kotak dengan satu lingkaran putih adalah yang tepat untuk mengisinya. Kotak yang terletak pada  huruf <b>"f"</b> itulah jawabannya.</p>
			
			<p><b>Waktu anda terbatas, bekerjalah dengan cepat, teliti dan tepat.</b></p>
			
			<input type="button" value="OK" onclick="setBacaTipeUjian('.$kondisi.')" id="fvpp-close" style="display:none">
			
			</div>

		</div>
		';
	}
	elseif($kondisi == 11)
	{
		$statement= '
		<div class="area-instruksi">'.$judul.'
			
			<div class="keterangan">
			<p>Lihatlah gambar contoh yang pertama. Anda akan melihat 1 (satu) gambar di sebelah kiri dan 5 (lima) gambar di sebelah kanannya.
Pada gambar di sebelah kiri, Anda lihat ada sebuah titik. Titik ini terletak di dalam bujur sangkar dan di dalam lingkaran.
</p>
			
			<span><img src="../../images/intruksi/a_subtes4_contoh1.jpg"></span>
			
			<p>Sekarang lihatlah pada 5 gambar yang berada di sebelah kanan. Gambar manakah yang mungkin diletakkan sebuah titik di dalam lingkaran dan juga di dalam bujur sangkar.</p>
			
			<p>Jawabannya adalah gambar yang terletak di atas huruf <b>"c"</b>.</p> 
			
			<p>Ingat, Anda diminta untuk mencari titik dalam kondisi yang sama seperti gambar soal (kiri).</p>
			
			<p>Sekarang lihat contoh kedua. Perhatikan gambar dalam kotak sebelah kiri. Dimanakah kemungkinan letak titik tersebut?</p>
			
			<span><img src="../../images/intruksi/a_subtes4_contoh2.jpg"></span>
			
			<p>Titik tersebut berada di dalam segitiga tetapi di luar segi panjang.</p>
			
			<p>Jawabannya adalah gambar yang terletak dibawah huruf <b>"d"</b>. Maka pilihlah jawaban <b>"d"</b>.</p>			
			
			<p>Contoh ketiga. Lihatlah gambar yang terletak di sebelah kiri. Dimanakah letak titik?
Titik itu terletak di dalam segitiga, dan di atas garis lengkung. Sekarang lihat gambar-gambar di sebelah kanan. Carilah kemungkinan gambar yang letak titiknya serupa dengan yang dipersoalkan.
</p>

			<span><img src="../../images/intruksi/a_subtes4_contoh3.jpg"></span>
			
			<p>Gambar yang benar adalah yang berada pada huruf <b>"b"</b>.</p>
			
			<p>Gunakanlah imajinasi Anda untuk mencari kemungkinan letak titik tersebut.</p>

			<p><b>Waktu anda terbatas, bekerjalah dengan cepat, teliti dan tepat.</b></p>
			
			<input type="button" value="OK" onclick="setBacaTipeUjian('.$kondisi.')" id="fvpp-close" style="display:none">
			
			</div>

		</div>
		';
	}
	elseif($kondisi == 12)
	{
		$statement= '
		<div class="area-instruksi">'.$judul.'
		 
			
			<div class="keterangan"> 
			<p>Lihatlah gambar-gambar pada contoh pada tes ini. Kita lihat contoh pada baris pertama. Disitu Anda lihat lingkaran-lingkaran dari yang terbesar berurutan sampai yang paling kecil, mulai dari gambar di kotak pertama sampai pada kotak ketiga.</p>
		 
			<span><img src="../../images/intruksi/b_subtes1_contoh1.jpg"></span>
		 
			
			<p>Dapatkah Anda memilih 1 (satu) kotak selanjutnya diantara 6 (enam) kotak yang telah tersedia?</p>
			
			<p>Kotak <b>"c"</b> adalah yang tepat untuk gambar lingkaran yang paling terkecil. Maka pilihlah <b>"c"</b> untuk jawaban Anda.</p>
			
		 		
			<p>Sekarang lihatlah contoh kedua. Anda dapat lihat beberapa batang kayu (stick) yang berdiri sejajar sama tinggi, dari satu batang lalu bertambah menjadi dua batang, tiga dan seterusnya bertambah satu persatu. Tentunya Anda tahu, di kotak mana yang berisi kayu lebih banyak.</p>
			
			<span><img src="../../images/intruksi/b_subtes1_contoh2.jpg"></span>
			
			<p>Kotak <b>"e"</b> adalah yang tepat untuk gambar selanjutnya, maka pilihlah jawaban <b>"e"</b>.</p>
			
			<p>Sekarang kita beralih pada contoh ketiga. Lihatlah gambar seperti dua stick golf dan sebuat titik di atara keduanya. Dari tegak, miring dan makin lama merebah. Bagaimana Anda mengetahui kelanjutan dari gambar-gambar tersebut?</p>
			
             <span><img src="../../images/intruksi/b_subtes1_contoh3.jpg"></span>
						
			<p>Kotak <b>"e"</b> adalah yang tepat untuk gambar selanjutnya.</p>
			
			<p>Mulailah dari no. 1 – 13. <b>Waktu anda terbatas, bekerjalah dengan cepat, teliti dan tepat.</b></p>
			
			<input type="button" value="OK" onclick="setBacaTipeUjian('.$kondisi.')" id="fvpp-close" style="display:none">
			
			</div>

		</div>
		';
	}
	elseif($kondisi == 13)
	{
		$statement= '
		<div class="area-instruksi">'.$judul.'			
			<div class="keterangan"> 
			<p>Lihatlah gambar-gambar contoh pada baris pertama. Disitu ada 3 (tiga) kotak yang mempunyai bentuk gambar yang sama, tetapi 2 (dua) kotak lain yang mempunyai bentuk gambar yang berbeda.
Tugas Anda adalah mencari pada setiap baris soal, 2 kotak yang gambarnya berbeda dengan gambar 3 kotak lainnya. Apabila Anda telah menemukan 2 kotak yang berbeda tersebut, maka pilihlah 2 (dua) huruf jawaban yang mewakili kotak tersebut.
</p>
			
			<span><img src="../../images/intruksi/b_subtes2_contoh1.jpg"></span>
			
			<p>Pada gambar di garis pertama, Anda melihat ada 3 (tiga) kotak yang gambarnya seperti beduk dengan lingkaran hitam di atasnya, dan 2 kotak lain yang bergambar <b>lingkaran</b>. Jadi, 2 kotak yang bergambar <b>lingkaran</b> itulah jawabannya.</p>
			
			<p>Kedua gambar itu berada di kotak dengan huruf <b>"b"</b> dan <b>"d"</b>. Maka Anda harus memilih jawaban  <b>"b"</b> dan <b>"d"</b>.</p>
			
		 		
			<p>Sekarang lihatlah contoh pada baris kedua. Carilah 2 (dua) gambar yang berbeda dengan 3 (tiga) gambar lainnya.</p>
			
			<span><img src="../../images/intruksi/b_subtes2_contoh2.jpg"></span>
			
			<p>Jawabannnya adalah <b>"c"</b> dan <b>"e"</b>.</p>
					 
			<p>Sekali lagi, tugas Anda adalah memilih 2 kotak atau 2 gambar yang berbeda dengan gambar-gambar yang lainnya pada setiap baris soal. Jadi, anda harus memilih 2 jawaban.</p>
			
			<p><b>Waktu anda terbatas, bekerjalah dengan cepat, teliti dan tepat.</b></p>
			
			<input type="button" value="OK" onclick="setBacaTipeUjian('.$kondisi.')" id="fvpp-close" style="display:none">
			
			</div>

		</div>
		';
	}
	elseif($kondisi == 14)
	{
		$statement= '
		<div class="area-instruksi">'.$judul.'
			<div class="keterangan"> 
			<p>Perhatikan gambar-gambar yang berisi 3 garis tegak lurus di dalam setiap kotak, tapi ada 1 kotak yang kosong atau hilang. Kotak yang hilang ini terletak di antara 6 kotak kecil yang berada di sebelah kanan. Pilihlah salah satu.
</p>
			
			<span><img src="../../images/intruksi/b_subtes3_contoh1.jpg"></span>
			
			<p>Perhatikan, kotak kedua lah yang tepat untuk mengisi kotak yang kosong itu. Kotak kedua ini terletak pada huruf <b>"b"</b>. Maka pilihlah jawaban <b>"b"</b>.</p>
			
		 
			<p>Sekarang lihatlah contoh kedua. Manakah jawaban yang benar?</p>
			
			<span><img src="../../images/intruksi/b_subtes3_contoh2.jpg"></span>
			
			<p>Kotak yang terletak pada huruf <b>"c"</b> yang tepat untuk mengisi kotak kecil yang hilang tersebut, karena yang hilang itu adalah gambar <b>telunjuk tangan berbintik</b> yang menghadap ke kanan. Maka pilihlah jawaban sesuai dengan yang anda anggap benar tersebut.</p>
					 
			<p>Sekarang perhatikan kotak ketiga. Di dalam kotak yang besar, berisi 4 (empat) kotak yang terdapat garis-garis tebal. Kotak yang 1 (satu) garis tebal berwarna berpasangan dengan kotak yang bergaris 2 (dua) tebal berwarna pula. Sedangkan dibawahnya ada 1 (satu) kotak yang bergaris satu putih, Anda harus mencari kotak pasangan yang bergaris dua putih.</p>
			
			<span><img src="../../images/intruksi/b_subtes3_contoh3.jpg"></span>
			
			<p>Kotak yang terletak pada  huruf <b>"f"</b> itulah jawabannya.</p>
			
			<b><p>Waktu anda terbatas, bekerjalah dengan cepat, teliti dan tepat.</p></b>
			
			<input type="button" value="OK" onclick="setBacaTipeUjian('.$kondisi.')" id="fvpp-close" style="display:none">
			
			</div>

		</div>
		';
	}
	elseif($kondisi == 15)
	{
		$statement= '
		<div class="area-instruksi">'.$judul.'
			<div class="keterangan"> 
			<p>Lihatlah gambar contoh yang pertama. Anda akan melihat 1 (satu) gambar di sebelah kiri dan 5 (lima) gambar di sebelah kanannya.
Pada gambar di sebelah kiri, Anda lihat di dalam kotak ada gambar lingkaran, kotak persegi panjang dan sebuah titik. Perhatikan titik tersebut. titik tersebut berada di dalam kotak persegi panjang namun di luar lingkaran.
</p>
			<p>Sekarang lihatlah pada 5 gambar yang berada di sebelah kanan. Gambar manakah yang mungkin diletakkan sebuah titik di dalam kotak persegi panjang namun di luar lingkaran?</p>
			
			<span><img src="../../images/intruksi/b_subtes4_contoh1.jpg"></span>
			
			<p>Jawabannya adalah gambar yang terletak di atas huruf <b>"c"</b>.</p>
			
		 
			<p>Ingat, Anda diminta untuk mencari titik dalam kondisi yang sama seperti gambar soal (kiri).</p>
			
			<p>Sekarang lihat contoh kedua. Perhatikan gambar dalam kotak sebelah kiri. Dimanakah kemungkinan letak titik tersebut?</p>
			
			<span><img src="../../images/intruksi/b_subtes4_contoh2.jpg"></span>
			
			<p>Titik tersebut berada di dalam 2 (dua) buah segitiga. Sekarang, lihatlah contoh ketiga. Lihat gambar pada kotak sebelah kiri. Dimanakah letak titik tersebut?</p>
			
			<p>Jawabannya adalah gambar yang terletak dibawah huruf <b>"d"</b>. Maka pilihlah jawaban <b>"d"</b>.</p>
					 
			<p>Contoh ketiga. Lihatlah gambar yang terletak di sebelah kiri. Dimanakah letak titik?
Titik itu terletak di dalam segitiga, dan di atas garis lengkung. Sekarang lihat gambar-gambar di sebelah kanan. Carilah kemungkinan gambar yang letak titiknya serupa dengan yang dipersoalkan.
</p>
			
			<span><img src="../../images/intruksi/b_subtes4_contoh3.jpg"></span>
			
			<p>Gambar yang benar adalah yang berada pada huruf <b>"b"</b>.</p>
			<p>Gunakanlah imajinasi Anda untuk mencari kemungkinan letak titik tersebut.</p>
			
			<b><p>Waktu anda terbatas, bekerjalah dengan cepat, teliti dan tepat.</p></b>
			
			<input type="button" value="OK" onclick="setBacaTipeUjian('.$kondisi.')" id="fvpp-close" style="display:none">
			
			</div>

		</div>
		';
	}
	elseif($kondisi == 3)
	{
		$statement= '
		<div class="area-instruksi">'.$judul.'			
			<div class="keterangan"> 
			<b><p>Kerjakan Ujian dengan baik, waktu Saudara terbatas, Kerjakan dengan cepat, teliti dan tepat.</p></b>
			
			<input type="button" value="OK" onclick="setBacaTipeUjian('.$kondisi.')" id="fvpp-close" style="display:none">
			
			</div>

		</div>
		';
	}
	elseif($kondisi == 4)
	{
		$statement= '
		<div class="area-instruksi">'.$judul.'
		 	
			<div class="keterangan"> 
			<b><p>Kerjakan Ujian dengan baik, waktu Saudara terbatas, Kerjakan dengan cepat, teliti dan tepat.</p></b>
			
			<input type="button" value="OK" onclick="setBacaTipeUjian('.$kondisi.')" id="fvpp-close" style="display:none">
			
			</div>

		</div>
		';
	}
	elseif($kondisi == 5)
	{
		$statement= '
		<div class="area-instruksi">'.$judul.'
		 	
			<div class="keterangan"> 
			<b><p>Kerjakan Ujian dengan baik, waktu Saudara terbatas, Kerjakan dengan cepat, teliti dan tepat.</p></b>
			
			<input type="button" value="OK" onclick="setBacaTipeUjian('.$kondisi.')" id="fvpp-close" style="display:none">
			
			</div>

		</div>
		';
	}
	elseif($kondisi == 6)
	{
		$statement= '
		<div class="area-instruksi">'.$judul.'
		 	
			<div class="keterangan"> 
			<b><p>Kerjakan Ujian dengan baik, waktu Saudara terbatas, Kerjakan dengan cepat, teliti dan tepat.</p></b>
			
			<input type="button" value="OK" onclick="setBacaTipeUjian('.$kondisi.')" id="fvpp-close" style="display:none">
			
			</div>

		</div>
		';
	}
	elseif($kondisi == 7)
	{
		$statement= '
		<div class="area-instruksi">'.$judul.'
		 
			<span style="color: red">(Wajib terisi seluruhnya)</span>
			 
			<div class="keterangan">
			<p>Di dalam tes ini terdapat <b>90 (Sembilan Puluh)</b> pasang <b>PERNYATAAN</b>. Pilihlah <b>1 (satu) PERNYATAAN </b> dari pasangan pernyataan itu yang menurut Saudara <b>PALING MENDEKATI GAMBARAN DIRI Saudara</b>, atau yang paling menunjukan perasaan Saudara. </p>
			<p>Kadang-kadang Saudara merasa bahwa kedua pernyataan itu tidak sesuai benar dengan diri Saudara, namun demikian Saudara tetap diminta tetap memilih <b> 1 (satu) pernyataan yang PALING MENUNJUKAN DIRI Saudara</b>. Pilihan Saudara didasarkan atas kesukaan Saudara sekarang dan tidak didasarkan atas apa yang Saudara anggap wajar. </p>
			<p>Tidak ada jawaban Benar atau Salah. Kerjakan dengan teliti dan jangan ada pernyataan yang terlewati</p>
			<p>Perhatikan contoh di bawah ini : </p>
			<ul style="border: 1px solid #000;">
				<p style="padding-left: 20px;"> ⚪Saya seorang pekerja "keras"</p>
				<p style="padding-left: 20px;"> ⚪Saya bukan seorang pemurung</p>
			</ul>
			<br>
			<p>Bila Saudara <b>seorang pekerja "keras"</b> , maka <b>tekanlah </b> pada pernyataan tersebut. </p>

			<p>Contoh :</p>
			<ul style="border: 1px solid #000;">
				<p style="padding-left: 20px;"> ⚫Saya seorang pekerja "keras"</p>
				<p style="padding-left: 20px;"> ⚪Saya bukan seorang pemurung</p>
			</ul>
			<br>
			<p>Tetapi bila Saudara bukan seorang pemurung, maka tekanlah pada pernyataan tersebut.</p>

			<p>Contoh : </p>

			<ul style="border: 1px solid #000;">
				<p style="padding-left: 20px;"> ⚪Saya seorang pekerja "keras"</p>
				<p style="padding-left: 20px;"> ⚫Saya bukan seorang pemurung</p>
			</ul>
			<br>
			<p>Jawaban Saudara di buat dengan memilih pada jawaban dengan cara menekan / klik pada lingkaran di sebelah pernyataan pilihan Saudara ATAU pada kalimat pernyataanya pilihan Saudara.
			</p>
			<p>Ini bukan suatu tes. Disini tidak ada jawaban benar atau salah. Apa yang Saudara pilih hendaknya merupakan suatu gambaran dari apa yang Saudara suka lakukan.
			</p>


			<p>Apabila Saudara sudah memahami,<b> tekan</b> tulisan <b>OK</b>. <b>Waktu akan berjalan setelah Saudara menekan OK</b>. Waktu Saudara terbatas, Kerjakan dengan cepat, teliti dan tepat</p>

			<input type="button" value="OK" onclick="setBacaTipeUjian('.$kondisi.')" id="fvpp-close" style="display:none">
			
			</div>

		</div>
		';
	}
	elseif($kondisi == 17)
	{
		$statement= '
		<div class="area-instruksi">'.$judul.'
		 	
			<div class="keterangan"> 
			<p>Saudara akan membaca sejumlah pernyataan mengenai berbagai hal yang mungkin menggambarkan diri Saudara</p>
			<p>atau mungkin juga tidak menggambarkan diri Saudara, dan pernyataan-pernyataan tersebut selalu disajikan berpasangan</p>
			<p style="text-align: center"><strong>Perhatikan contoh di bawah ini : </strong></p>
			
			<ul style="list-style-type: upper-alpha">
				<li>Saya suka berbicara tentang diri saya dengan orang lain</li>
				<li>Saya suka bekerja untuk suatu tujuan yang telah saya tentukan bagi diri saya</li>
			</ul>

			<p>Manakah dari dua pernyataan tersebut, yang lebih menggambarkan diri Saudara ?</p>
			<p>Bila Saudara lebih mirip <strong>suka berbicara tentang diri Saudara dengan orang lain </strong>, daripada</p>
			<p><strong>suka bekerja untuk suatu tujuan yang telah Saudara tentukan bagi diri Saudara</strong>, maka </p>
			<p>Saudara hendaknya memilih <strong>A</strong></p>
			<p>Tetapi bila Saudara lebih mirip <strong>suka bekerja untuk suatu tujuan yang telah Saudara tentukan bagi diri Saudara </strong>daripada</p>
			<p><strong>suka berbicara dengan orang lain </strong>, maka hendaknya Saudara memilih <strong>B</strong></p>

			<input type="button" value="OK" onclick="setBacaTipeUjian('.$kondisi.')" id="fvpp-close" style="display:none">
			
			</div>

		</div>
		';
	}

	elseif($kondisi == 16 || $kondisi == 43)
	{
		$statement= '
		<div class="area-instruksi">'.$judul.'


		<div class="keterangan"> 
		<br>
		<table style="width: 100%;" >
		<tbody><tr style="/*! height: 300px; */">
		<td style=" width: 200px;">
		<p><strong>Contoh Soal Tes Kraepelin</strong></p>
		<img src="../../images/intruksi/gambar2.gif"></td>
		<td style="text-align: top;text-align: justify;vertical-align: text-top; border: 1px solid #000; text-align: top;text-align: justify;vertical-align: text-top; border: 1px solid #000;padding-left: 20px;padding-top: 20px;padding-right: 20px;padding-bottom: 20px;" align="top">
		<p>&emsp;Tugas Saudara adalah menjumlahkan antara satu bilangan dengan satu bilangan lain tepat diatasnya yang terdapat dalam deretan angka yang terbagi dalam lajur-lajur. Saudara wajib menjumlahkan mulai dari lajur paling kiri dan paling bawah ke atas secara berurutan. Waktu yang diberikan di setiap lajur sangat terbatas. Oleh sebab itu, Saudara diminta menjumlahkan secara cepat, teliti dan tepat </p>
		<ul style="list-style-type: upper-alpha"> <strong>Tata Cara Pengerjaan :</strong>
			<li>Sebelum memulai, pastikan Saudara pahami <strong>letak angka</strong> pada laptop atau PC dimana Saudara akan gunakan terlebih dulu (hafalkan letak angka 1 hingga 0);</li>
			<li>Ketika akan <strong>menekan MULAI </strong>warna pada lajur menjadi abu-abu muda dan akan muncul deretan angka secara berurutan;</li>
			<li>Jika dalam penjumlahan angka, Saudara menemukan hitungan yang jumlahnya belasan tulis <strong>angka satuan</strong>nya saja (Misal 13, cukup tekan angka 3);</li>			
			<li>Jika secara otomatis warna pada lajur yang sedang kerjakan berubah menjadi abu-abu tua/gelap, artinya waktu pengerjaan pada lajur tersebut sudah habis. Saudara wajib berpindah ke lajur samping kanan dan mulai lagi menghitung dari paling bawah ke atas secara berurutan;</li>
			<li>Apabila dalam mengerjakan hitungan, ada salah hitung, cukup pindahkan kursor pada kolom jawaban yang akan Saudara ganti;</li>
			<li>Setelah selesai isi angka, soal akan secara langsung berpindah atau naik ke soal selanjutnya atau secara otomatis naik ke soal selanjutnya</li>
		</ul>
		</td>
		<br>
		</tbody>
		</table>
		


		<br>
		<input type="button" value="OK" onclick="setBacaTipeUjian('.$kondisi.')" id="fvpp-close" style="display:none">

		</div>

		</div>
		';
	}
	elseif($kondisi == 19)
	{
		$statement= '
		<div class="area-instruksi">'.$judul.'

		<div class="judul" >
		<b><p>PETUNJUK DAN CONTOH UNTUK KELOMPOK SOAL 01</p></b>
		</div>
		<div class="keterangan"> 
		<p>Soal-soal pada tes ini terdiri atas kalimat-kalimat.</p>
		<p>Pada setiap kalimat 1 (satu) kata hilang dan disediakan 5 (lima) kata pilihan sebagai penggantinya.</p> 
		<p>Pilihlah kata yang tepat yang dapat menyempurnakan kalimat itu ! </p>
		<br>
		<p><b>Contoh 01</b></p>
		<br>
		<p>Seekor kuda mempunyai kesamaan terbanyak dengan seekor .................. </p>
		<p>⚪ Kucing<br>
		⚪ Bajing <br>
		⚫ Keledai <br>
		⚪ lembu <br>
		⚪ anjing</p>
		<p> Jawaban yang benar ialah : keledai</p>
		<p> Oleh karena itu, pada pilihan jawaban <b>"Keledai"</b> di contoh 01 harus dipilih</p>
		<br>
		<p><b>Contoh berikutnya :</b></p>
		<br>
		<p>Lawannya "harapan" ialah ................</p>
		<p> ⚪ duka<br> ⚫ putus asa<br> ⚪ sengsara<br> ⚪ cinta<br> ⚪ benci</p>
		<br>
		<p> Jawabannya ialah : putus asa</p>
		<p> Maka jawaban <b>"putus asa"</b> yang seharusnya pilih</p>
		<br>
		<p>Apabila Saudara sudah memahami,<b> tekan</b> tulisan <b>OK</b>. <b>Waktu akan berjalan setelah Saudara menekan OK</b>. Waktu Saudara terbatas, Kerjakan dengan cepat, teliti dan tepat</p><br>
		<input type="button" value="OK" onclick="setBacaTipeUjian('.$kondisi.')" id="fvpp-close" style="display:none">
		</div>
		</div>
		';
	}
	elseif($kondisi == 20)
	{
		$statement= '
		<div class="area-instruksi">'.$judul.'

		<div class="judul" >
		<b><p>PETUNJUK DAN CONTOH UNTUK KELOMPOK SOAL 02</p></b>
		</div>
		<br>
		<div class="keterangan"> 
		<p>Ditentukan 5 kata.</p>
		<p>Pada 4 (empat) dari 5 (lima) kata itu terdapat suatu kesamaan.</p>
		<p>Carilah kata yang kelima yang tidak memiliki kesamaan dengan keempat kata itu.</p>
		<br>
		<b>Contoh 01</b>
		<br>
		<p>⚪ meja<br>
		⚪ kursi <br>
		⚫ burung <br>
		⚪ lemari <br>
		⚪ tempat tidur</p>
		<br>
		<p> <b> meja, kursi, lemari, dan tempat tidur</b> ialah <b>perabot rumah (meubel)</b></p>
		<p> <b>burung</b>, bukan perabot rumah atau tidak memiliki kesamaan dengan keempat kata itu.</p>
		<p> Oleh karena itu,pilihan jawaban <b>"burung"</b> harus dipilih.</p>
		<br>
		<b>Contoh berikutnya :</b>
		<br>
		<p>⚪ duduk<br>
		⚪ berbaring <br>
		⚪ berdiri <br>
		⚫ berjalan <br>
		⚪ berjongkok</p>
		<br>
		<p> <b>duduk, berbaring, berdiri, dan berjongkok</b> orang berada dalam keadaan tidak bergerak, <b>sedangkan</b> berjalan orang dalam keadaan bergerak.</p>
		<p> Maka Jawaban yang benar ialah : &nbsp berjalan</p>
		<p> Oleh karena itu pilihan jawaban <b>"berjalan"</b> yang seharusnya dipilih.</p>
		<br>
		<p>Apabila Saudara sudah memahami,<b> tekan</b> tulisan <b>OK</b>. <b>Waktu akan berjalan setelah Saudara menekan OK</b>. Waktu Saudara terbatas, Kerjakan dengan cepat, teliti dan tepat</p><br>
		<input type="button" value="OK" onclick="setBacaTipeUjian('.$kondisi.')" id="fvpp-close" style="display:none">
		</div>
		</div>
		';
	}
	elseif($kondisi == 21)
	{
		$statement= '
		<div class="area-instruksi">'.$judul.'

		<div class="judul" >
		<b><p>PETUNJUK DAN CONTOH UNTUK KELOMPOK SOAL 03</b>
		</div>
		<br>
		<div class="keterangan"> 
		<p>Ditentukan 3 (tiga) kata.</p> 
		<p>Antara kata pertama dan kata kedua terdapat suatu hubungan yang tertentu. 
			<br> Antara kata ketiga dan salah satu diantara lima kata pilihan harus pula terdapat hubungan yang sama itu.
			<br> carilah kata itu.
		</p>
		<br>
		<b>Contoh 01</b>
		<br>
		<p>Hutan : pohon = tembok : ? </p>
		<p>⚫  batu bata<br>
		⚪ rumah <br>
		⚪ semen <br>
		⚪ putih <br>
		⚪ dinding</p>
		<br>
		<p> Hubungan antara hutan dan pohon ialah bahwa hutan terdiri atas pohon-pohon, maka hubungan antara tembok dan salah satu kata pilihan ialah bahwa tembok terdiri atas batu-batu bata.</p>
		<p> Oleh karena itu, Oleh karena itu, pilihan <b>"batu bata"</b> harus dipilih..</p>
		<br>
		<b>Contoh berikutnya :</b>
		<br>
		<p>Gelap : terang = basah : ?</p>
		<p>⚪ hujan<br>
		⚪ hari <br>
		⚪ lembab <br>
		⚪ angin <br>
		⚫ kering</p>
		<br>
		<p> Gelap ialah lawannya dari terang, maka untuk basah lawannya ialah kering.</p>
		<p> Maka jawaban yang benar ialah : &nbsp kering</p>
		<p> Oleh karena, Oleh karena itu pilihan jawaban <b>"kering"</b> yang seharusnya dipilih.</p>
		<br>
		<p>Apabila Saudara sudah memahami,<b> tekan</b> tulisan <b>OK</b>. <b>Waktu akan berjalan setelah Saudara menekan OK</b>. Waktu Saudara terbatas, Kerjakan dengan cepat, teliti dan tepat</p><br>
		<input type="button" value="OK" onclick="setBacaTipeUjian('.$kondisi.')" id="fvpp-close" style="display:none">
		</div>
		</div>
		';
	}
	elseif($kondisi == 22)
	{
		$statement= '
		<div class="area-instruksi">'.$judul.'

		<div class="judul" >
		<b><p>PETUNJUK DAN CONTOH UNTUK KELOMPOK SOAL 04</p></b>
		</div>
		<br>
		<div class="keterangan"> 
		<p>Ditentukan 2 (dua) kata.</p>
		<p>Carilah satu perkataan yang meliputi pengertian kedua kata tadi. </p>
		<p>Tuliskan perkataan itu pada lembar jawaban di belakang nomor soal yang sesuai.</p>
		<br>
		<b>Contoh 01</b>
		<br>
		<p>Ayam - itik</p>
		<p><table><tr><td style="border: solid black 1px; padding: 5px; width:200px"> burung <td style=" width:10px"></td><td style="border: solid black 1px; background-color:#cdcdcd"> Simpan</td></tr></table>
		<br>
		<p>Perkataan "burung" dapat meliputi pengertian kedua kata itu</p>
		<p>Maka jawabannya ialah <b>"burung"</b></p>
		<p>Oleh karena itu, <b>pada kolom jawaban</b>, harus diketik <b>"burung". Lalu tekan "simpan"</b></p>
		<br>
		<b>Contoh berikutnya :</b>
		<br>
		<p>Gaun - celana</p>
		<p><table><tr><td style="border: solid black 1px; padding: 5px; width:200px"> Pakaian <td style=" width:10px"></td><td style="border: solid black 1px; background-color:#cdcdcd"> Simpan</td></tr></table>
		<br>
		<p>Maka <b>"pakaian"</b> yang seharusnya diketik. Lalu tekan <b>"simpan"</b></p>
		<p>Carilah selalu perkataan yang tepat yang dapat meliputi pengertian kedua kata itu.</p>
		<br>
		<p>Apabila Saudara sudah memahami,<b> tekan</b> tulisan <b>OK</b>. <b>Waktu akan berjalan setelah Saudara menekan OK</b>. Waktu Saudara terbatas, Kerjakan dengan cepat, teliti dan tepat</p><br>
		<input type="button" value="OK" onclick="setBacaTipeUjian('.$kondisi.')" id="fvpp-close" style="display:none">
		</div>
		</div>
		';
	}
	elseif($kondisi == 23)
	{
		$statement= '
		<div class="area-instruksi">'.$judul.'

		<div class="judul" >
		<b><p>PETUNJUK DAN CONTOH UNTUK KELOMPOK SOAL 05</b>
		</div>
		<br>
		<div class="keterangan"> 
		<p>Persoalan berikutnya ialah soal-soal hitungan.</p>
		<br>
		<p><b>Contoh 1</b></p>
		<p>Sebatang pensil harganya 25 rupiah. Berapakah harga 3 batang ?</p>
		<p style="font-size:20px">☐ 1 &nbsp ☐ 2 &nbsp ☐ 3 &nbsp ☐ 4 &nbsp ☑ 5</p>
		<p style="font-size:20px">☐ 6 &nbsp ☑ 7 &nbsp ☐ 8 &nbsp ☐ 9 &nbsp ☐ 0</p>
		<p>Jawabannya ialah : 75</p>
		<p>Oleh karena itu, <b>pada kolom jawaban</b>, angka 7 dan 5 harus <b>dipilih</b> pada <b>kolom jawaban</b>.</p>
		<br>
		<p><b>Contoh 2</b></p>
		<p>Dengan sepeda Husin dapat mencapai 15 km dalam waktu 1 jam, Berapa km-kah yang dapat ia capai dalam waktu 4 jam ?</p>
		<p style="font-size:20px">☐ 1 &nbsp ☐ 2 &nbsp ☐ 3 &nbsp ☐ 4 &nbsp ☐ 5</p>
		<p style="font-size:20px">☑ 6 &nbsp ☐ 7 &nbsp ☐ 8 &nbsp ☐ 9 &nbsp ☑ 0</p>
		<p>Jawabannya ialah : 60</p>
		<p>Oleh karena itu, <b>pada kolom jawaban</b>, angka 6 dan 0 harus <b>dipilih</b> pada <b>kolom jawaban</b>.</p>
		<br>
		<p>Setelah yakin dengan jawaban yang Saudara pilih, silakan tekan ‘SELANJUTNYA’ untuk berpindah ke nomor selanjutnya.</p><br>
		<p>Apabila Saudara sudah memahami,<b> tekan</b> tulisan <b>OK</b>. <b>Waktu akan berjalan setelah Saudara menekan OK</b>. Waktu Saudara terbatas, Kerjakan dengan cepat, teliti dan tepat</p><br>
		<input type="button" value="OK" onclick="setBacaTipeUjian('.$kondisi.')" id="fvpp-close" style="display:none">
		</div>
		</div>
		';
	}
	elseif($kondisi == 24)
	{
		$statement= '
		<div class="area-instruksi">'.$judul.'
		<div class="judul" >
		<b><p>PETUNJUK DAN CONTOH UNTUK KELOMPOK SOAL 06</p></b>
		</div>
		<br>
		<div class="keterangan"> 
		<p>Pada persoalan berikut akan diberikan deret angka.</p> 
		<p>Setiap deret tersusun menurut suatu aturan yang tertentu dan dapat dilanjutkan menurut aturan itu.</p> 
		<p>Carilah untuk setiap deret, angka berikutnya dan pilihlah jawaban Saudara pada pilihan jawaban yang tersedia.</p>
		<br>
		<p><b>Contoh 1</b></p>
		<p> 2 &nbsp - &nbsp 4 &nbsp - &nbsp 6 &nbsp - &nbsp 8 &nbsp - &nbsp 10 &nbsp - &nbsp 12 &nbsp - &nbsp 14 &nbsp - &nbsp ?</p>
		<p>☑ 1 &nbsp ☐ 2 &nbsp ☐ 3 &nbsp ☐ 4 &nbsp ☐ 5</p>
		<p>☑ 6 &nbsp ☐ 7 &nbsp ☐ 8 &nbsp ☐ 9 &nbsp ☐ 0</p>
		<br>
		<p> Pada deret ini angka berikutnya selalu didapat jika angka didepannya ditambah dengan <b>2</b>.</p>
		<p> Maka jawabannya ialah <b>16</b>,</p>
		<p> Oleh karena itu, <b>pada pilihan jawaban</b>, angka 1 dan 6 harus dipilih pada pilihan jawaban.</p>
		<br>
		<p><b>Contoh 2</b></p>
		<p> 9 &nbsp - &nbsp 7 &nbsp - &nbsp 10 &nbsp - &nbsp 8 &nbsp - &nbsp 11 &nbsp - &nbsp 9 &nbsp - &nbsp 12 &nbsp - &nbsp ?</p>
		<p>☑ 1 &nbsp ☐ 2 &nbsp ☐ 3 &nbsp ☐ 4 &nbsp ☐ 5</p>
		<p>☐ 6 &nbsp ☐ 7 &nbsp ☐ 8 &nbsp ☐ 9 &nbsp ☑ 0</p>
		<br>
		<p> Pada deret ini selalu berganti-ganti harus dikurangi dengan 2 dan setelah itu ditambah dengan 3</p>
		<p> jawaban contoh ini ialah : <b>10</b>, maka dari itu <b>angka 1 dan 0</b> seharusnya dipilih pada pilihan jawaban.</p>
		<br>
		<p> Kadang-kadang pada beberapa soal harus pula <b>dikalikan atau dibagi</b>.</p>
		<br>
		<p>Setelah yakin dengan jawaban yang Saudara pilih, silakan tekan ‘SELANJUTNYA’ untuk berpindah ke nomor selanjutnya.</p></br>
		<p>Apabila Saudara sudah memahami,<b> tekan</b> tulisan <b>OK</b>. <b>Waktu akan berjalan setelah Saudara menekan OK</b>. Waktu Saudara terbatas, Kerjakan dengan cepat, teliti dan tepat</p><br>
		<input type="button" value="OK" onclick="setBacaTipeUjian('.$kondisi.')" id="fvpp-close" style="display:none">
		</div>
		</div>
		';
	}
	elseif($kondisi == 25)
	{
		$statement= '
		<div class="area-instruksi">'.$judul.'

		<div class="judul" >
		<b><p>PETUNJUK DAN CONTOH UNTUK KELOMPOK SOAL 07</p></b>
		</div>
		<br>
		<div class="keterangan"> 
		<p>Pada persoalan berikutnya, setiap soal memperlihatkan sesuatu bentuk tertentu yang terpotong menjadi beberapa bagian. </p>
		<p>Carilah di antara bentuk-bentuk yang ditentukan (a,b,c,d,e), bentuk yang dapat dibangun dengan cara menyusun potongan-potongan itu sedemikian rupa, sehingga tidak ada kelebihan sudut atau ruang diantaranya. </p>
		<p>Pilihlah yang menunjukkan bentuk tadi pada <b>pilihan jawaban</b> yang sesuai. </p>
		<p><b>Contoh 1</b></p>
		<img src="../../images/intruksi/soal7a.jpg">
		<p> Jika potongan-potongan pada contoh 1 diatas disusun (digabungkan), maka akan menghasilkan bentuk <b>a</b>.</p>
		<p> Oleh karena itu, <b>pada pilihan jawaban</b> huruf <b>a</b> harus dipilih</p>
		<br>
		<p><b>Contoh 2</b></p>
		<img src="../../images/intruksi/soal7b.jpg">
		<p> Potongan-potongan pada contoh 2 diatas disusun (digabungkan), maka akan menghasilkan bentuk <b>e</b>.</p>
		<br>
		<p><b>Contoh 3</b></p>
		<img src="../../images/intruksi/soal7c.jpg">
		<p> Potongan-potongan pada contoh 3 diatas disusun (digabungkan), maka akan menghasilkan bentuk <b>b</b>.</p>
		<br>
		<p><b>Contoh 4</b></p>
		<img src="../../images/intruksi/soal7d.jpg">
		<p> Potongan-potongan pada contoh 4 diatas disusun (digabungkan), maka akan menghasilkan bentuk <b>d</b>.</p>
		<br>
		<p>Apabila Saudara sudah memahami,<b> tekan</b> tulisan <b>OK</b>. <b>Waktu akan berjalan setelah Saudara menekan OK</b>. Waktu Saudara terbatas, Kerjakan dengan cepat, teliti dan tepat</p><br>
		<input type="button" value="OK" onclick="setBacaTipeUjian('.$kondisi.')" id="fvpp-close" style="display:none">
		</div>
		</div>
		';
	}
	elseif($kondisi == 26)
	{
		$statement= '
		<div class="area-instruksi">'.$judul.'

		<div class="judul" >
		<b><p>PETUNJUK DAN CONTOH UNTUK KELOMPOK SOAL 08</p></b>
		</div>
		<div class="keterangan"> 
		<p>Ditentukan 5 (lima) buah kubus a,b,c,d,e. Pada tiap-tiap kubus terdapat 6 (enam) tanda yang berlainan pada setiap sisinya. 3 (tiga) dari tanda itu dapat dilihat.
		<br>Kubus-kubus yang ditentukan itu (a, b, c, d, e) ialah kubus-kubus yang berbeda, artinya kubus-kubus itu dapat mempunyai tanda - tanda yang sama, akan tetapi susunannya berlainan. Setiap soal memperlihatkan salah satu kubus yang ditentukan di dalam kedudukan yang berbeda.</p>
		<p>Carilah kubus yang dimaksudkan itu dan pilihlah jawaban yang sesuai.Kubus itu dapat diputar, dapat digulingkan atau dapat diputar dan digulingkan dalam pikiran Saudara.</p>
		<p>Oleh karena itu mungkin akan terlihat suatu tanda yang baru.</p>
		<br>
		<p><b>Contoh 1</b></p>
		<img src="../../images/intruksi/soal8a.png">
		<p>Contoh ini memperlihatkan kubus <b>"a"</b> dengan kedudukan yang berbeda.</p>
		<p>Cara mendapatkannya adalah dengan cara <b>menggulingkan</b> lebih dahulu kubus itu <b>ke kiri satu kali</b> dan kemudian <b>diputar ke kanan satu kali</b>, sehingga sisi kubus yang tanda dua segi empat hitam terletak di depan, seperti kubus <b>"a"</b>.</p>
		<br>
		<p><b>Contoh 2</b></p>
		<img src="../../images/intruksi/soal8b.png">
		<p>Contoh kedua menjadi bentuk <b>"e"</b></p>
		<p>Cara mendapatkannya adalah dengan digulingkan <b>ke kiri satu kali </b> dan <b>diputar ke kanan satu kali</b>. Sehingga sisi kubus yang bertanda garis silang terletak di depan, seperti kubus <b>"e"</b>.</p>
		<br>
		<p><b>Contoh 3</b></p>
		<img src="../../images/intruksi/soal8c.png">
		<p>Contoh ketiga menjadi bentuk <b>"b"</b></p>
		<p>Cara mendapatkannya adalah dengan digulingkan <b>ke kiri satu kali dan diputar ke kanan satu kali</b>, Sehingga sisi kubus yang berttanda garis silang terletak di depan, seperti kubus "e".</p>
		<br>
		<p><b>Contoh 4</b></p>
		<img src="../../images/intruksi/soal8d.png">
		<p>Contoh keempat menjadi bentuk <b>"c"</b></p>
		<br>
		<p><b>Contoh 5</b></p>
		<img src="../../images/intruksi/soal8e.png">
		<p>Contoh kelima menjadi bentuk <b>"d"</b></p>
		<br>
		<p>Apabila Saudara sudah memahami,<b> tekan</b> tulisan <b>OK</b>. <b>Waktu akan berjalan setelah Saudara menekan OK</b>. Waktu Saudara terbatas, Kerjakan dengan cepat, teliti dan tepat</p><br>
		<input type="button" value="OK" onclick="setBacaTipeUjian('.$kondisi.')" id="fvpp-close" style="display:none">
		</div>
		</div>
		';
	}
	elseif($kondisi == 27)
	{
		$statement= '
		<div class="area-instruksi">'.$judul.'
		 	
			<div class="judul" >
			<b><p>PETUNJUK DAN CONTOH UNTUK KELOMPOK SOAL 09</b>
			</div>
			<div class="keterangan"> 
			<p> Pada persoalan berikutnya, terdapat sejumlah pertanyaan mengenai kata-kata yang telah Saudara hafalkan tadi. Pilihlah jawaban Saudara pada lembaran jawaban di belakang nomor soal yang sesuai.</p>
			<br>
			<b>Contoh 1</b>
			<p> Kata yang mempunyai huruf permulaan - Q - adalah suatu .................</p>
			<p>⚪ bunga <br> 
			⚪ perkakas <br> 
			⚪ burung <br> 
			⚫ kesenian <br> 
			⚪ binatang </p>
			<p>Quintet adalah termasuk dalam jenis kesenian. sehingga jawaban yang benar adalah <b>"kesenian"</b>.</p>
			<p>Oleh karena itu, pilihan <b>"kesenian"</b> harus dipilih</p>
			<br>
			<b>Contoh 2</b>
			<p> Kata yang mempunyai huruf permulaan - Z - adalah suatu .................</p>
			<p>⚪ bunga <br> 
			⚪ perkakas <br> 
			⚪ burung <br> 
			⚪ kesenian <br> 
			⚫ binatang </p>
			<p>Jawabannya adalah <b>Zebra</b> , karena Zebra termasuk dalam jenis binatang.</p>
			<p>Maka jawaban <b>"Binatang"</b> yang seharusnya pilih.</p>
			<br>
			<p>Apabila Saudara sudah memahami,<b> tekan</b> tulisan <b>OK</b>. <b>Waktu akan berjalan setelah Saudara menekan OK</b>. Waktu Saudara terbatas, Kerjakan dengan cepat, teliti dan tepat</p><br>
			<input type="button" value="OK" onclick="setBacaTipeUjian('.$kondisi.')" id="fvpp-close" style="display:none">
			
			</div>

		</div>
		';
	}

	elseif($kondisi == 42 )
	{
		$statement= '
		<div class="area-instruksi">'.$judul.'
		 
			<span style="color: red">(Wajib terisi seluruhnya)</span>
			
			<div class="keterangan"> 		
			<p>Dalam test ini akan disediakan (empat) 4 kalimat yang akan Saudara pilih </p>
			<p> Tugas Saudara adalah memilih satu (1) + (PLUS) dan satu (1) - (MINUS)</p>
			<p>1. Klik ⚪ pada kolom Tanda + (PLUS) disamping kalimat yang <strong>paling</strong> menggambarkan diri Saudara</p>
			<p>2. Klik ⚪ pada kolom Tanda - (MINUS) disamping kalimat yang <strong>kurang</strong> menggambarkan diri Saudara </p>
			<p>Setiap nomor hanya ada 1 (SATU) jawaban + (plus) dan – (minus).</p>
			<p>Tidak ada jawaban salah. Bacalah instruksi dengan teliti, apabila sudah jelas, tekan OK. Waktu akan berjalan ketika Saudara menekan OK. Kerjakan dengan teliti dan jangan ada soal yang terlewati. </p>
			<p>Perhatikan contoh di bawah ini : </p>
			<table style="border: 1px solid #000; text-align: center;">
			  <tr>
			    <td style="font-size: 28px;">+</td>
			    <td></td>
			    <td style="font-size: 28px;">-</td>
			  </tr>
			  <tr>
			    <td style="width:200px">⚪</td>
			    <td style="width:700px">Ramah dan mengalah</td>
			    <td style="width:200px">⚪</td>
			  </tr>
			  <tr>
			    <td>⚪</td>
			    <td>Mengandalkan Insting</td>
			    <td>⚪</td>
			  </tr>
			  <tr>
			    <td>⚪</td>
			    <td>Mudah mempercayai orang lain</td>
			    <td>⚪</td>
			  </tr>
			  <tr>
			    <td>⚪</td>
			    <td>Memerintah orang lain</td>
			    <td>⚪</td>
			  </tr>
			</table>
			<br>
			<p>Bila Saudara lebih cenderung memilih Mengandalkan Insting untuk menggambarkan diri Saudara. Maka Saudara memilih pada ⚪ pada kolom + (PLUS) di sebelah kiri pernyataan</p>
			<p>Bila Saudara lebih cenderung memilih Memerintah orang lain untuk menggambarkan yang bukan diri Saudara. Maka Saudara memilih pada ⚪ pada kolom - (MINUS) di sebelah kanan pernyataan.</p>

			<table style="border: 1px solid #000; text-align: center;">
			  <tr>
			    <td style="font-size: 28px;">+</td>
			    <td></td>
			    <td style="font-size: 28px;">-</td>
			  </tr>
			  <tr>
			    <td style="width:200px">⚪</td>
			    <td style="width:700px">Ramah dan mengalah</td>
			    <td style="width:200px">⚪</td>
			  </tr>
			  <tr>
			    <td>⚫</td>
			    <td>Mengandalkan Insting</td>
			    <td>⚪</td>
			  </tr>
			  <tr>
			    <td>⚪</td>
			    <td>Mudah mempercayai orang lain</td>
			    <td>⚪</td>
			  </tr>
			  <tr>
			    <td>⚪</td>
			    <td>Memerintah orang lain</td>
			    <td>⚫</td>
			  </tr>
			</table>
			<br>
			<p>Kerjakan dengan Cepat dan teliti, Serta jangan sampai ada soal yang terlewati.</p>
			<br>

			<p>Apabila Saudara sudah memahami, <b>tekan</b> tulisan <b>OK</b>. <b>Waktu akan berjalan setelah Saudara menekan OK.</b> </p>
			<br>
			<input type="button" value="OK" onclick="setBacaTipeUjian('.$kondisi.')" id="fvpp-close" style="display:none">
			
			</div>

		</div>
		';
	}
	elseif($kondisi == 40)
	{
		$statement= '
		<div class="area-instruksi">'.$judul.'
		 	<span style="color: red"> (Wajib terisi seluruhnya)</span>

			<div class="keterangan"> 
		
			<p>Pada tugas ini, Saudara akan dihadapkan pada 105 pernyataan. Saudara harus memilih salah satu dari 3 (tiga) pilihan yang tersedia.</p>
			<p>Pilihan tersebut hendaknya sesuai kenyataan pada diri Saudara sendiri, serta menggambarkan keadaan sebenarnya. </p>
			<p>Tidak ada jawaban yang benar atau salah. <b>Waktu Saudara terbatas</b> dalam pengerjaan tes ini, sehingga respon pertama adalah yang paling diharapkan. Dalam menjawab pernyataan-pernyataan tersebut, usahakan untuk memilih <b>"Ya"</b> dan <b>"Tidak"</b>. Pilihan <b>"Kadang-Kadang"</b> atau <b>"Diantaranya"</b> hanya dipilih ketika benar-benar merasa ragu.</p>

			<p>Perhatikan contoh di bawah ini : </p>
			<ul style="border: 1px solid #000;">
				<p style="padding-left: 20px;"> Saya orang yang sangat tenang dan santai ?</p>
				<p style="padding-left: 20px;"> ⚪Ya</p>
				<p style="padding-left: 20px;"> ⚪Kadang-Kadang</p>
				<p style="padding-left: 20px;"> ⚪Tidak</p>
			</ul>
			<br>
			<p>Bila Saudara memilih <b>"Ya"</b> sebagai pilihan Saudara, hendaknya memilih pada pilihan yang tersedia.</p>

			<p>Contoh :</p>
			<ul style="border: 1px solid #000;">
				<p style="padding-left: 20px;"> Saya orang yang sangat tenang dan santai ?</p>
				<p style="padding-left: 20px;"> ⚫Ya</p>
				<p style="padding-left: 20px;"> ⚪Kadang-Kadang</p>
				<p style="padding-left: 20px;"> ⚪Tidak</p>
			</ul>
			<br>
			<p>Begitu juga dengan keadaan dimana Saudara memilih <b>"Tidak"</b>, <b>"Kadang-Kadang"</b> atau <b>"Diantaranya"</b> .</p>
			<br>

			<p>Waktu Saudara terbatas, Kerjakan dengan teliti dan jangan ada soal yang terlewati.</p>
			<br>

			<p>Apabila Saudara sudah memahami, <b>tekan</b> tulisan <b>OK</b>. <b>Waktu akan berjalan setelah Saudara menekan OK.</b> </p>
			<br>
			
			<br>
			<input type="button" value="OK" onclick="setBacaTipeUjian('.$kondisi.')" id="fvpp-close" style="display:none">
			
			</div>

		</div>
		';
	}
	elseif( ($kondisi >= 19 && $kondisi < 40 )  )
	{
		$statement= '
		<div class="area-instruksi">'.$judul.'
		 
			
			<div class="keterangan"> 
			<b><p>Kerjakan Ujian dengan baik, waktu Saudara terbatas, Kerjakan dengan cepat, teliti dan tepat.</p></b>
			
			<input type="button" value="OK" onclick="setBacaTipeUjian('.$kondisi.')" id="fvpp-close" style="display:none">
			
			</div>

		</div>
		';
	}
	elseif($kondisi == 45)
	{
		$statement= '
		<div class="area-instruksi">'.$judul.'
			<div class="keterangan"> 
		
			<p>Pada tes ini, setiap nomor berisi satu pernyataan. Tugas Saudara adalah menentukan <b>kesesuaian</b> pada setiap pernyataan dengan keadaan diri Saudara yang sebenarnya.</p><br>
			
			<p>Apabila Saudara sudah memahami, <b>tekan</b> tulisan <b>OK</b>. <b>Waktu akan berjalan setelah Saudara menekan OK. Kerjakan dengan baik, waktu Saudara terbatas.  </b></p>
			<br>
			
			<br>
			<input type="button" value="OK" onclick="setBacaTipeUjian('.$kondisi.')" id="fvpp-close" style="display:none">
			
			</div>

		</div>
		';
	}
	elseif($kondisi == 66 )
	{
		$statement= '
		<div class="area-instruksi">'.$judul.'
			<span style="color: red">(Wajib terisi seluruhnya)</div>
			<div class="keterangan"> 
			<b>
			Pada halaman selanjutnya, Saudara akan menghadapi sejumlah pernyataan. Tugas Saudara memilih satu (1) dari dua (2) pernyataan yang sesuai/tidak sesuai atau mendekati/tidak mendekati dengan diri Saudara. Tidak ada jawaban Salah dan Benar. Bacalah instruksi dengan benar. Apabila Saudara sudah paham, tekan OK. Waktu akan berjalan Ketika Saudara menekan OK. Kerjakan seluruh soal dengan teliti, benar dan cepat. Seluruh soal pernyataan wajib diisi. </p>
			</b>
			
			<input type="button" value="OK" onclick="setBacaTipeUjian('.$kondisi.')" id="fvpp-close" style="display:none">
			
			</div>

		</div>
		';
	}
	elseif($kondisi == 46)
	{
		$statement= '
		<div class="area-instruksi">'.$judul.'
			
			<div class="keterangan"> 
			<b><p>Kerjakan Ujian dengan baik, waktu Saudara terbatas, Kerjakan dengan cepat, teliti dan tepat.</p></b>
			
			<input type="button" value="OK" onclick="setBacaTipeUjian('.$kondisi.')" id="fvpp-close" style="display:none">
			
			</div>

		</div>
		';
	}
	elseif($kondisi == 47)
	{
		$statement= '
		<div class="area-instruksi">'.$judul.'
			<div class="keterangan"> 
			<p>
			Tes ini berisi 50 pertanyaan yang secara bertahap menjadi semakin sulit. Saudara tidak mungkin dapat menyelesaikan semua pertanyaan, tetapi selesaikan semampu Saudara. Saudara memiliki waktu 12 menit untuk memberi jawaban yang benar sebanyak mungkin. Kerjakan dengan teliti, namun jangan menghabiskan waktu lama pada setiap pertanyaan atau lewati pertanyaan itu. Pastikan Saudara menjawab pada tempat yang disediakan. 
			<br><br><b>CONTOH SOAL 1</b><br><br>
			Perhatikan satu contoh pertanyaan yang terisi dengan benar:<br>
			MENUAI adalah lawan kata dari <br>
			⚪ mendapat<br>
			⚪ bersorak<br>
			⚪ melanjutkan<br>
			⚪ berada<br>
			⚪ menabur<br><br>
			Jawaban yang benar adalah "menabur". Maka, tulislah klik jawaban "menabur" di sebelah kiri pilihan jawaban<br><br>
			<b>CONTOH SOAL 2</b><br><br>
			Jawablah contoh pertanyaan berikut ini.<br>
			<img src="../../images/intruksi/wpt.jpg">
			<br><br> <b>CONTOH SOAL 3</b> <br><br>
			<b>MINER     MINOR</b>. Apakah kata-kata ini<br>
			⚪ memiliki arti sama<br>
			⚪ memiliki arti berlawanan<br>
			⚪ tidak memiliki arti sama atau berlawanan<br><br>
			Jawaban yang benar adalah ‘tidak memiliki arti sama atau berlawanan‘. Maka klik jawaban ‘tidak memiliki arti sama atau berlawanan‘ pada bagian kiri pilihan jawaban. </p>
			<br>
			<p>Untuk jawaban angka desimal, menggunakan Saudara titik (.) sebagai pengganti koma (,). Contoh : 2,50 diketik 2.50</p>
			<input type="button" value="OK" onclick="setBacaTipeUjian('.$kondisi.')" id="fvpp-close" style="display:none">
			<p>Apabila Saudara sudah memahami, <b>tekan</b> tulisan <b>OK</b>. <b>Waktu akan berjalan setelah Saudara menekan OK. </b>Kerjakan dengan baik, waktu Saudara terbatas.  </p>
			<br>

			</div>

		</div>
		';
	}
	elseif($kondisi == 48)
	{
		$statement= '
		<div class="area-instruksi">'.$judul.'
		 
			<div class="keterangan"> 
			<p> Pada tes ini memiliki pernyataan sangat mungkin mencerminkan/sesuai dengan pikiran, perasaan dan perilaku Saudara sehari-hari atau juga sebaliknya Berilah nilai pada kotak kosong yang tersedia mulai dari angka 0 sampai dengan 5. <br><br>Besar kecilnya nilai merupakan gambaran dari tingkat kesesuaian diri Saudara dengan pernyataan yang disediakan <br><br>semakin tinggi nilai, berarti semakin besar kesesuaian). <br><br>Pemberian nilai dapat ditulis dengan angka desimal contoh : 1.5 atau 4.3 dan seterusnya. <br><br>Tidak ada jawaban benar atau salah, semua tergantung dari tingkat kesesuaian diri Saudara. <br><br>Usahakan dikerjakan dengan baik dan cepat, karena waktunya terbatas.</p>
			
			<input type="button" value="OK" onclick="setBacaTipeUjian('.$kondisi.')" id="fvpp-close" style="display:none">
			
			</div>

		</div>
		';
	}
	elseif($kondisi == 49)
	{
		$statement= '
		<div class="area-instruksi">'.$judul.'

			<div class="keterangan"> 
		
			<p>Saudara akan membaca sejumlah pilihan <b>pekerjaan/aktivitas/kompetensi</b> mengenai berbagai hal yang mungkin Saudara sukai atau mungkin juga tidak.</p><br>
			<p>Tugas Saudara adalah memilih pilihan suka pada pilihan pekerjaan/aktivitas/kompetensi yang Saudara <b>sukai dan sebaliknya.</b></p><br>
			
			<p>Apabila Saudara sudah memahami, <b>tekan</b> tulisan <b>OK</b>. <b>Waktu akan berjalan setelah Saudara menekan OK. Kerjakan dengan baik, waktu Saudara terbatas.  </b></p>
			<br>
			
			<br>
			<input type="button" value="OK" onclick="setBacaTipeUjian('.$kondisi.')" id="fvpp-close" style="display:none">
			
			</div>

		</div>
		';
	}
	elseif($kondisi == 50)
	{
		$statement= '
		<div class="area-instruksi">'.$judul.'
			<div class="keterangan"> 
			<b><p>Kerjakan Ujian dengan baik, waktu Saudara terbatas, Kerjakan dengan cepat, teliti dan tepat.</p></b>
			
			<input type="button" value="OK" onclick="setBacaTipeUjian('.$kondisi.')" id="fvpp-close" style="display:none">
			
			</div>

		</div>
		';
	}
	elseif($kondisi == 51)
	{
		$statement= '
		<div class="area-instruksi">'.$judul.'
		 			
			<div class="keterangan"> 
			<b><p>Kerjakan Ujian dengan baik, waktu Saudara terbatas, Kerjakan dengan cepat, teliti dan tepat.</p></b>
			
			<input type="button" value="OK" onclick="setBacaTipeUjian('.$kondisi.')" id="fvpp-close" style="display:none">
			
			</div>

		</div>
		';
	}
	elseif($kondisi == 52)
	{
		$statement= '
		<div class="area-instruksi">'.$judul.'	
			<div class="keterangan"> 
			<b><p>Kerjakan Ujian dengan baik, waktu Saudara terbatas, Kerjakan dengan cepat, teliti dan tepat.</p></b>
			
			<input type="button" value="OK" onclick="setBacaTipeUjian('.$kondisi.')" id="fvpp-close" style="display:none">
			
			</div>

		</div>
		';
	}
	elseif($kondisi == 53)
	{
		$statement= '
		<div class="area-instruksi">'.$judul.'
			
			<div class="keterangan"> 
			<b><p>Kerjakan Ujian dengan baik, waktu Saudara terbatas, Kerjakan dengan cepat, teliti dan tepat.</p></b>
			
			<input type="button" value="OK" onclick="setBacaTipeUjian('.$kondisi.')" id="fvpp-close" style="display:none">
			
			</div>

		</div>
		';
	}
	elseif($kondisi == 54)
	{
		$statement= '
		<div class="area-instruksi">'.$judul.'
		 			
			<div class="keterangan"> 
			<b><p>Kerjakan Ujian dengan baik, waktu Saudara terbatas, Kerjakan dengan cepat, teliti dan tepat.</p></b>
			
			<input type="button" value="OK" onclick="setBacaTipeUjian('.$kondisi.')" id="fvpp-close" style="display:none">
			
			</div>

		</div>
		';
	}
	elseif($kondisi == 55)
	{
		$statement= '
		<div class="area-instruksi">'.$judul.'
		 	
			<div class="keterangan"> 
			<b><p>Kerjakan Ujian dengan baik, waktu Saudara terbatas, Kerjakan dengan cepat, teliti dan tepat.</p></b>
			
			<input type="button" value="OK" onclick="setBacaTipeUjian('.$kondisi.')" id="fvpp-close" style="display:none">
			
			</div>

		</div>
		';
	}
	elseif($kondisi == 56)
	{
		$statement= '
		<div class="area-instruksi">'.$judul.'
		 
			<div class="keterangan"> 
			<b><p>Kerjakan Ujian dengan baik, waktu Saudara terbatas, Kerjakan dengan cepat, teliti dan tepat.</p></b>
			
			<input type="button" value="OK" onclick="setBacaTipeUjian('.$kondisi.')" id="fvpp-close" style="display:none">
			
			</div>

		</div>
		';
	}
	elseif($kondisi == 57)
	{
		$statement= '
		<div class="area-instruksi">'.$judul.'
		 
			
			<div class="keterangan"> 
			<b><p>Kerjakan Ujian dengan baik, waktu Saudara terbatas, Kerjakan dengan cepat, teliti dan tepat.</p></b>
			
			<input type="button" value="OK" onclick="setBacaTipeUjian('.$kondisi.')" id="fvpp-close" style="display:none">
			
			</div>

		</div>
		';
	}
	elseif($kondisi == 58)
	{
		$statement= '
		<div class="area-instruksi">'.$judul.'
		 
			
			<div class="keterangan"> 
			<b><p>Kerjakan Ujian dengan baik, waktu Saudara terbatas, Kerjakan dengan cepat, teliti dan tepat.</p></b>
			
			<input type="button" value="OK" onclick="setBacaTipeUjian('.$kondisi.')" id="fvpp-close" style="display:none">
			
			</div>

		</div>
		';
	}
	elseif($kondisi == 59)
	{
		$statement= '
		<div class="area-instruksi">'.$judul.'
		 
			
			<div class="keterangan"> 
			<b><p>Kerjakan Ujian dengan baik, waktu Saudara terbatas, Kerjakan dengan cepat, teliti dan tepat.</p></b>
			
			<input type="button" value="OK" onclick="setBacaTipeUjian('.$kondisi.')" id="fvpp-close" style="display:none">
			
			</div>

		</div>
		';
	}
	elseif($kondisi == 60)
	{
		$statement= '
		<div class="area-instruksi">'.$judul.'
		 
			
			<div class="keterangan"> 
			<b><p>Kerjakan Ujian dengan baik, waktu Saudara terbatas, Kerjakan dengan cepat, teliti dan tepat.</p></b>
			
			<input type="button" value="OK" onclick="setBacaTipeUjian('.$kondisi.')" id="fvpp-close" style="display:none">
			
			</div>

		</div>
		';
	}
	elseif($kondisi == 61)
	{
		$statement= '
		<div class="area-instruksi">'.$judul.'
		 	
			<div class="keterangan"> 
			<b><p>Kerjakan Ujian dengan baik, waktu Saudara terbatas, Kerjakan dengan cepat, teliti dan tepat.</p></b>
			
			<input type="button" value="OK" onclick="setBacaTipeUjian('.$kondisi.')" id="fvpp-close" style="display:none">
			
			</div>

		</div>
		';
	}
	elseif($kondisi == 62)
	{
		$statement= '
		<div class="area-instruksi">'.$judul.'
		 
			
			<div class="keterangan"> 
			<b><p>Kerjakan Ujian dengan baik, waktu Saudara terbatas, Kerjakan dengan cepat, teliti dan tepat.</p></b>
			
			<input type="button" value="OK" onclick="setBacaTipeUjian('.$kondisi.')" id="fvpp-close" style="display:none">
			
			</div>

		</div>
		';
	}
	elseif($kondisi == 63)
	{
		$statement= '
		<div class="area-instruksi">'.$judul.'
		 
			
			<div class="keterangan"> 
			<b><p>Kerjakan Ujian dengan baik, waktu Saudara terbatas, Kerjakan dengan cepat, teliti dan tepat.</p></b>
			
			<input type="button" value="OK" onclick="setBacaTipeUjian('.$kondisi.')" id="fvpp-close" style="display:none">
			
			</div>

		</div>
		';
	}
	elseif($kondisi == 64)
	{
		$statement= '
		<div class="area-instruksi">'.$judul.'
		 
			<div class="judul">TES SKB PARIWISATA</div>
			
			<div class="keterangan"> 
			<b><p>Kerjakan Ujian dengan baik, waktu Saudara terbatas, Kerjakan dengan cepat, teliti dan tepat.</p></b>
			
			<input type="button" value="OK" onclick="setBacaTipeUjian('.$kondisi.')" id="fvpp-close" style="display:none">
			
			</div>

		</div>
		';
	}
	elseif($kondisi == 65)
	{
		$statement= '
		<div class="area-instruksi">'.$judul.'
		 
			<div class="judul">TES SKB PUBLIKASI DATA</div>
			
			<div class="keterangan"> 
			<b><p>Kerjakan Ujian dengan baik, waktu Saudara terbatas, Kerjakan dengan cepat, teliti dan tepat.</p></b>
			
			<input type="button" value="OK" onclick="setBacaTipeUjian('.$kondisi.')" id="fvpp-close" style="display:none">
			
			</div>

		</div>
		';
	}
	elseif($kondisi == 41)
	{
		$statement= '
		<div class="area-instruksi">'.$judul.'
		 	
		
			<div class="keterangan"> 
			
			<p>Di bawah ini terdapat 60 (enam puluh) pasang pernyataan.</p>
			<p>Masing-masing nomor memiliki DUA PERNYATAAN yang bertolak belakang.</p>

			<p>Pilihlah salah <b>SATU PERNYATAAN</b> yang paling <b>SESUAI DENGAN DIRI Saudara pada pilihan</b> jawaban Saudara. </p><br>
			<p>Disini tidak ada jawaban benar atau salah. </p>
			<p>Saudara HARUS memilih salah satu yang paling menggambarkan diri Saudara, serta mengisi semua nomor.</p>

			<p>Apabila Saudara sudah memahami, <b>tekan</b> tulisan <b>OK</b>. <b>Waktu akan berjalan setelah Saudara menekan OK. Kerjakan dengan baik, waktu Saudara terbatas.  </b></p>
			<br>
			
			<br>
			<input type="button" value="OK" onclick="setBacaTipeUjian('.$kondisi.')" id="fvpp-close" style="display:none">
			
			</div>

		</div>
		';
	}
	elseif($kondisi == 70)
	{
		$statement= '
		<div class="area-instruksi">'.$judul.'
		 
			
			<div class="keterangan"> 
			<p>Persoalan ini adalah menyelesaikan kalimat dengan cara memilih <b>1 (satu)</b> kata yang telah tersedia dibawah setiap soal. </p><br>
			<p>Pada setiap soal disediakan <b>4 (empat)</b> pilihan jawaban.</p><br>
			<p>Tugas Saudara adalah memilih salah satu jawaban yang Saudara anggap paling benar.</p><br>

			<p>Contoh 1</p>
			<img src="../../images/intruksi/tkd2_1.png">
			<br>
			<br>
			<p>Contoh 2</p>
			<img src="../../images/intruksi/tkd2_2.png">
			<br>
			<br>
			<p>Apabila Saudara sudah memahami,<b> tekan</b> tulisan <b>OK</b>. <b>Waktu akan berjalan setelah Saudara menekan OK</b>. Waktu Saudara terbatas, Kerjakan dengan cepat, teliti dan tepat</p>	
			<br>		
			<input type="button" value="OK" onclick="setBacaTipeUjian('.$kondisi.')" id="fvpp-close" style="display:none">
			
			</div>

		</div>
		';
	}
	elseif($kondisi == 71)
	{
		$statement= '
		<div class="area-instruksi">'.$judul.'
		 
			
			<div class="keterangan"> 
			<b><p>Jenis Soal : Memilih Kemungkinan Jawaban</p></b><br>
			<p>Pada tes ini Saudara akan menemukan 20 (dua puluh) pertanyaan. Saudara diminta untuk memilih salah satu jawaban yang paling sesuai dari 3 (tiga) kemungkinan jawaban yang tersedia dibawahnya.</p><br>
			<b>CONTOH SOAL 1</b><br><br>
			Mengapa pada musim liburan kita senang beristirahat di tempat yang sejuk<br>
			⚪ Karena hal itu adalah mode<br>
			⚫ Karena hawa sejuk baik untuk kesehatan<br>
			⚪ Karena kita harus mendukung hotel - hotel
			<br>
			<br>
			<p>Pilihan jawaban yang sesuai adalah "Karena hawa sejuk baik untuk kesehatan". </p>
			<p>Maka tekan pilihan jawaban <b>"Karena hawa sejuk baik untuk kesehatan"</b> untuk menunjukkan jawaban Saudara.</p>
			<p>Apabila Saudara sudah memahami,<b> tekan</b> tulisan <b>OK</b>. <b>Waktu akan berjalan setelah Saudara menekan OK</b>. Waktu Saudara terbatas, Kerjakan dengan cepat, teliti dan tepat</p>	
			<br>	
			
			<input type="button" value="OK" onclick="setBacaTipeUjian('.$kondisi.')" id="fvpp-close" style="display:none">
			
			</div>

		</div>
		';
	}
	elseif($kondisi == 72)
	{
		$statement= '
		]<div class="area-instruksi">'.$judul.'
				
			<div class="keterangan"> 
			<p>Persoalan ini adalah Persoalan Berhitung.</p><br>
			<p>Ketiklah jawaban Saudara pada kolom yang tersedia. Saudara hanya diminta mengetik <b>angkanya saja</b>. Jadi, satuannya seperti rupiah, kilogram, jam dan sebagainya tidak perlu diketik.</p><br>
			<p>Contoh</p>
			<img src="../../images/intruksi/tkd5_01.png">
			<br>
			<br>
			<p>Jawabannya adalah 31, ketiklah angka <b>"31"</b> sebagai jawaban Saudara pada kolom yang tersedia. Setelah itu tekan Saudara <b>"SIMPAN"</b>, untuk menyimpan jawaban Saudara sebelum melanjutkan.</p>
			<br>
			<p>Untuk jawaban angka desimal, menggunakan Saudara titik (.) sebagai pengganti koma (,). Contoh : 2,50 diketik 2.50</p><br>
		
			<p>Apabila Saudara sudah memahami,<b> tekan</b> tulisan <b>OK</b>. <b>Waktu akan berjalan setelah Saudara menekan OK</b>. Waktu Saudara terbatas, Kerjakan dengan cepat, teliti dan tepat</p>	
			<br>	
			
			<input type="button" value="OK" onclick="setBacaTipeUjian('.$kondisi.')" id="fvpp-close" style="display:none">
			
			</div>

		</div>
		';
	}
	elseif($kondisi == 73)
	{
		$statement= '
		<div class="area-instruksi">'.$judul.'
		 
			<div class="judul">DIF 6</div>
			
			<div class="keterangan"> 
			<b><p>Jenis Soal : 𝐃𝐞𝐫𝐞𝐭 𝐀𝐧𝐠𝐤𝐚</p></b><br>
			<p>Pada tes berikut ini, Saudara dihadapkan pada 25 (dua puluh lima) soal deret. Tiap deret memiliki Irama. Tugas Saudara adalah menemukan irama pada deret tersebut. Lanjutkan <b>𝟐 𝐚𝐧𝐠𝐤𝐚 𝐭𝐞𝐫𝐚𝐤𝐡𝐢𝐫</b> pada tiap-tiap deret angka tersebut sesuai irama tersebut.</p><br>
			<p>Contoh</p>
			<img src="../../images/intruksi/tkd6_01.png">
			<br>
			<br>
			<p>Iramanya adalah <b>di tambah 3</b>, jawaban yang benar adalah "19" dan "22". Ketiklah angka 19 dan 22 sebagai jawaban Saudara pada kolom yang tersedia. Tekan Saudara <b>"SIMPAN"</b> untuk menyimpan jawaban Saudara sebelum melanjutkan.</p>
			<br>
			<br>
			<p>Contoh lainnya</p>
			<img src="../../images/intruksi/tkd6_02.png">
			<br>
			<br>
			<p>Iramanya adalah <b>di kurang 3 kemudian dikali 2</b>, jawaban yang benar adalah "22" dan "19". Ketiklah angka 22 dan 19 sebagai jawaban Saudara pada kolom yang tersedia. Tekan Saudara <b>"SIMPAN"</b> untuk menyimpan jawaban Saudara sebelum melanjutkan.</p><br>
			<p>Untuk jawaban angka desimal, menggunakan Saudara titik (.) sebagai pengganti koma (,). Contoh : 2,50 diketik 2.50</p><br>
		
			<p>Apabila Saudara sudah memahami,<b> tekan</b> tulisan <b>OK</b>. <b>Waktu akan berjalan setelah Saudara menekan OK</b>. Waktu Saudara terbatas, Kerjakan dengan cepat, teliti dan tepat</p>	
			<br>	
			
			<input type="button" value="OK" onclick="setBacaTipeUjian('.$kondisi.')" id="fvpp-close" style="display:none">
			
			</div>

		</div>
		';
	}
	elseif($kondisi == 74)
	{
		$statement= '
		<div class="area-instruksi">'.$judul.'
		 
			
			<div class="keterangan"> 
			<span><img src="../../images/intruksi/contoh_tkd_10.jpg"></span>
			
			<b><p>𝐒𝐈𝐋𝐀𝐇𝐊𝐀𝐍 𝐊𝐋𝐈𝐊 𝐏𝐀𝐃𝐀 𝐏𝐈𝐋𝐈𝐇𝐀𝐍 𝐉𝐀𝐖𝐀𝐁𝐀𝐍    𝐗 𝐚𝐭𝐚𝐮 𝐎</p></b>

			<p>Pilihan <b>O</b> untuk dua GAMBAR yang <b>SAMA</b>. </p><br>
			<p>Pilihan <b>X</b> untuk dua GAMBAR yang <b>BERBEDA</b>.</p><br>
			<p>Apabila Saudara sudah memahami,<b> tekan</b> tulisan <b>OK</b>. <b>Waktu akan berjalan setelah Saudara menekan OK</b>. Waktu Saudara terbatas, Kerjakan dengan cepat, teliti dan tepat</p>

			<input type="button" value="OK" onclick="setBacaTipeUjian('.$kondisi.')" id="fvpp-close" style="display:none">			
			</div>

		</div>
		';
	}
	elseif($kondisi == 74)
	{
		$statement= '
		<div class="area-instruksi">'.$judul.'
		 
			
			<div class="keterangan"> 
			<span><img src="../../images/intruksi/contoh_tkd_10.jpg"></span>
			
			<b><p>𝐒𝐈𝐋𝐀𝐇𝐊𝐀𝐍 𝐊𝐋𝐈𝐊 𝐏𝐀𝐃𝐀 𝐏𝐈𝐋𝐈𝐇𝐀𝐍 𝐉𝐀𝐖𝐀𝐁𝐀𝐍    𝐗 𝐚𝐭𝐚𝐮 𝐎</p></b>

			<p>Pilihan <b>O</b> untuk dua GAMBAR yang <b>SAMA</b>. </p><br>
			<p>Pilihan <b>X</b> untuk dua GAMBAR yang <b>BERBEDA</b>.</p><br>
			<p>Apabila Saudara sudah memahami,<b> tekan</b> tulisan <b>OK</b>. <b>Waktu akan berjalan setelah Saudara menekan OK</b>. Waktu Saudara terbatas, Kerjakan dengan cepat, teliti dan tepat</p>

			<input type="button" value="OK" onclick="setBacaTipeUjian('.$kondisi.')" id="fvpp-close" style="display:none">			
			</div>

		</div>
		';
	}
	else if($kondisi == "76"||$kondisi == "77"||$kondisi == "78"||$kondisi == "79"||$kondisi == "80"||$kondisi == "81"||$kondisi == "82"||$kondisi == "83")
	{
		$statement= '
		<div class="area-instruksi">'.$judul.'
		 
			
			<div class="keterangan"> 
			
			1. Pada ujian ini Anda akan diberikan beberapa situasi atau skenario yang menggambarkan masalah atau tantangan yang dapat terjadi di lingkungan kerja.<br>
			2. Setiap situasi akan diikuti dengan beberapa pilihan tindakan atau jawaban yang mungkin diambil.<br>
			3. Pilihlah jawaban yang menurut Anda paling sesuai dengan situasi yang diberikan.<br>

			<input type="button" value="OK" onclick="setBacaTipeUjian('.$kondisi.')" id="fvpp-close" style="display:none">			
			</div>

		</div>
		';
	}
	elseif($kondisi == 27000)
	{
		$statement= '
		<div class="area-instruksi">'.$judul.'
		 
			
			<div class="keterangan"> 
			
			<b><p>Disediakan Waktu 3 Menit Untuk Menghapalkan Kata-Kata .</p></b>

			<input type="button" value="OK" onclick="setBacaTipeUjianHafalan(27)" id="fvpp-close">			
			</div>

		</div>
		';
	}
	else
	{
		$statement= "Isilah dengan Jawaban Yang Tepat";
	}
	return $statement;
}

}