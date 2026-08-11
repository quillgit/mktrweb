<?php

	function konten()
	{			
		if (isset($_GET['menu'])) {	
			if ($_GET['menu']=="profile")						{include "modules/profile.php"; }
			elseif ($_GET['menu']=="banner")					{include "modules/banner.php"; }
			elseif ($_GET['menu']=="media_sosial")				{include "modules/media_sosial.php"; }
			elseif ($_GET['menu']=="penghargaan")				{include "modules/penghargaan.php"; }
			
			/* Tentang Kami */
			elseif ($_GET['menu']=="tentang")					{include "modules/tentang.php"; }
			elseif ($_GET['menu']=="struktur_organisasi")		{include "modules/struktur_organisasi.php"; }
			elseif ($_GET['menu']=="dewan_direksi")				{include "modules/dewan_direksi.php"; }
			elseif ($_GET['menu']=="berkelanjutan")				{include "modules/berkelanjutan.php"; }
			elseif ($_GET['menu']=="jejak_perusahaan")			{include "modules/jejak_perusahaan.php"; }
			elseif ($_GET['menu']=="hubungan_investor")			{include "modules/hubungan_investor.php"; }
			elseif ($_GET['menu']=="tatakelola_perusahaan")		{include "modules/tatakelola_perusahaan.php"; }


			elseif ($_GET['menu']=="bisnis_inti")				{include "modules/bisnis_inti.php"; }

			/* keberlanjutan */
			elseif ($_GET['menu']=="laporan_keberlanjutan")		{include "modules/laporan_keberlanjutan.php"; }
			elseif ($_GET['menu']=="laporan_kebijakan")			{include "modules/laporan_kebijakan.php"; }
			elseif ($_GET['menu']=="laporan_plan")				{include "modules/laporan_plan.php"; }
			elseif ($_GET['menu']=="laporan_kekayaan")			{include "modules/laporan_kekayaan.php"; }
			elseif ($_GET['menu']=="laporan_keluhan")			{include "modules/laporan_keluhan.php"; }

			elseif ($_GET['menu']=="laporan_rspo")				{include "modules/laporan_rspo.php"; }
			elseif ($_GET['menu']=="laporan_ispo")				{include "modules/laporan_ispo.php"; }
			elseif ($_GET['menu']=="laporan_setifikasi")			{include "modules/laporan_setifikasi.php"; }

			elseif ($_GET['menu']=="laporan_anggaran_dasar")		{include "modules/laporan_anggaran_dasar.php"; }
			elseif ($_GET['menu']=="laporan_kebijakan_tatakelola")	{include "modules/laporan_kebijakan_tatakelola.php"; }
			elseif ($_GET['menu']=="laporan_transaksi_afiliasi")	{include "modules/laporan_transaksi_afiliasi.php"; }
			elseif ($_GET['menu']=="laporan_umum_pemegang_saham")	{include "modules/laporan_umum_pemegang_saham.php"; }
			elseif ($_GET['menu']=="laporan_pedoman")				{include "modules/laporan_pedoman.php"; }
			
			/* NEWS */
			elseif ($_GET['menu']=="berita")					{include "modules/berita.php"; }
			elseif ($_GET['menu']=="perusahaan")				{include "modules/perusahaan.php"; }
			elseif ($_GET['menu']=="fasilitas")					{include "modules/fasilitas.php"; }
			
			elseif ($_GET['menu']=="inbox_contact_us")			{include "modules/inbox_contact_us.php"; }
			elseif ($_GET['menu']=="keanggotaan")				{include "modules/keanggotaan.php"; }
			
			/* INFORMASI PEMEGANG SAHAM */
			elseif ($_GET['menu']=="struktur_kepemilikan")		{include "modules/struktur_kepemilikan.php"; }
			elseif ($_GET['menu']=="riwayat_permodalan")		{include "modules/riwayat_permodalan.php"; }
			elseif ($_GET['menu']=="dividen")					{include "modules/dividen.php"; }
			elseif ($_GET['menu']=="rups")						{include "modules/rups.php"; }
			elseif ($_GET['menu']=="sumber_daya_manusia")		{include "modules/sumber_daya_manusia.php"; }
			
			/* INFORMASI KEUANGAN */
			elseif ($_GET['menu']=="laporan_kuartalan")			{include "modules/laporan_kuartalan.php"; }
			elseif ($_GET['menu']=="laporan_tahunan")			{include "modules/laporan_tahunan.php"; }
			elseif ($_GET['menu']=="prospektus")				{include "modules/prospektus.php"; }
			elseif ($_GET['menu']=="obligasi")					{include "modules/obligasi.php"; }

			elseif ($_GET['menu']=="laporan_keterbukaan_informasi")		{include "modules/laporan_keterbukaan_informasi.php"; }
			elseif ($_GET['menu']=="laporan_prospektus")				{include "modules/laporan_prospektus.php"; }
			elseif ($_GET['menu']=="laporan_keuangan")					{include "modules/laporan_keuangan.php"; }
			elseif ($_GET['menu']=="laporan_presentasi_perusahaan")		{include "modules/laporan_presentasi_perusahaan.php"; }
			elseif ($_GET['menu']=="laporan_buletin_investor")			{include "modules/laporan_buletin_investor.php"; }
			elseif ($_GET['menu']=="laporan_operasional")				{include "modules/laporan_operasional.php"; }
			
			/* NEWS */
			elseif ($_GET['menu']=="lowongan_kerja")			{include "modules/lowongan_kerja.php"; }
			elseif ($_GET['menu']=="magang")					{include "modules/magang.php"; }

			/* NEWS */
			elseif ($_GET['menu']=="setup_home")				{include "modules/setup_home.php"; }
			elseif ($_GET['menu']=="setup_banner")				{include "modules/setup_banner.php"; }
			
			elseif ($_GET['menu']=="link_rups")				    {include "modules/link_rups.php"; }
			elseif ($_GET['menu']=="pelaporan_pelanggaran")				    {include "modules/pelaporan_pelanggaran.php"; }
			
			elseif ($_GET['menu']=="pengaturan_user")			{include "modules/pengaturan_user.php"; }
			
			else 												{include "modules/home.php"; }
		}
			
	} 

	function slug($str)
	{
		$str = strtolower(trim($str));
		$str = preg_replace('/[^a-z0-9-]/', '-', $str);
		$str = preg_replace('/-+/', "-", $str);
		return $str;
	}

	function limitWord($string, $word_limit) {
		$words = explode(" ", $string);
		return implode(" ", array_splice($words, 0, $word_limit));
	}

	function TanggalIndo($date){
		
		$BulanIndo = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
	 
		$tahun = substr($date, 0, 4);
		$bulan = substr($date, 5, 2);
		$tgl   = substr($date, 8, 2);
	 
		$result = $tgl . " " . $BulanIndo[(int)$bulan-1] . " ". $tahun;		
		return($result);
	}
	
	function BulanTahunIndo($date){
		
		$BulanIndo = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
	 
		$tahun = substr($date, 0, 4);
		$bulan = substr($date, 5, 2);
		$tgl   = substr($date, 8, 2);
	 
		$result = $BulanIndo[(int)$bulan-1] . " ". $tahun;		
		return($result);
	}
	
	function format_rupiah($angka){
		$rupiah=number_format($angka,0,',','.');
		return $rupiah;
	}
	
	function antiinjection($data){
 
		$filter_sql = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
		 
		return $filter_sql;
	 
	}
?>