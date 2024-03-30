<?php
	require_once('../BackEnd/ConnectionDB/DB_classes.php');

	if(!isset($_POST['request']) && !isset($_GET['request'])) die(null);

	switch ($_POST['request']) {
    	// lấy tất cả loại sản phẩm (hãng)
    	case 'getall':
				$dslsp = (new LoaiSanPhamBUS())->select_all();
		    	die (json_encode($dslsp));
    		break;
		case 'delete':
			$spBUS = new LoaiSanPhamBUS();
			$maLSPDel = $_POST['malspdelete'];
			die (json_encode($lspBUS->delete_by_id($maLSPDel)));
		break;
    	default:
    		# code...
    		break;
    }

?>