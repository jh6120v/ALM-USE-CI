<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Captcha {	
	protected $CI;
	public $captcha;
	private $image;
	private $alpha = "abcdefghijkmnpqrstuvwxyz"; // 英文字串
	private $number = "23456789"; // 數字字串
	private $width; // 驗證碼寬度
	//自訂參數
	private $quantity = 4; // 驗證碼位數	
	private $height = 33; // 驗證碼高度
	private $fontsize = 20; // 字挺大小
	private $border = true; // 是否要邊框
	private $line = false; // 是否要干擾線
	private $bgcolor = array (255, 255, 255);
	private $fontcolor = array (255, 255, 255);
	private $bordercolor = array (255, 255, 255);
	
	public function __construct($params) {
		header ( "Content-type: image/PNG" );
		$this->CI =& get_instance();
		$this->quantity = isset($params ['quantity']) ? $params ['quantity'] : $this->quantity;
		$this->height = isset($params ['height']) ? $params ['height'] : $this->height;
		$this->fontsize = isset($params ['fontsize']) ? $params ['fontsize'] : $this->fontsize;
		$this->border = isset($params ['border']) ? $params ['border'] : $this->border;
		$this->line = isset($params ['line']) ? $params ['line'] : $this->line;
		$this->bgcolor = isset($params ['bgcolor']) ? $params ['bgcolor'] : $this->bgcolor;
		$this->fontcolor = isset($params ['fontcolor']) ? $params ['fontcolor'] : $this->fontcolor;
		$this->bordercolor = isset($params['bordercolor'])? $params['bordercolor'] : $this->bordercolor;
		$this->width = $this->quantity * 15;
	}
	public function getCaptcha() {
		$this->image = ImageCreate ( $this->width, $this->height );
		$bgcolor = ImageColorAllocate ( $this->image, $this->bgcolor[0], $this->bgcolor[1], $this->bgcolor[2] ); // 背景色
		ImageFill ( $this->image, 0, 0, $bgcolor ); // 填充背景色
		                                            
		// 檢查是否要邊框
		if ($this->border) {
			$this->makeBorder ();
		}
		// 開始生成
		for($i = 0; $i < $this->quantity; $i ++) {
			$alpha_or_number = mt_rand ( 0, 1 ); // 隨機取英文或數字
			$str = $alpha_or_number ? $this->alpha : $this->number;
			$which = mt_rand ( 0, strlen ( $str ) - 1 ); // 取英文或數字位置
			$code = substr ( $str, $which, 1 ); // 取英文或數字
			$j = ! $i ? 4 : $j + 15; // 字串位置
			$color3 = ImageColorAllocate ( $this->image, $this->fontcolor[0], $this->fontcolor[1], $this->fontcolor[2] ); // 字串顏色
			ImageChar ( $this->image, $this->fontsize, $j, 8, $code, $color3 ); // 依序寫入字串
			$this->captcha .= $code; // 生成字串
		}
		// 檢查是否要進行圖片干擾
		if ($this->line) {
			$this->mixedLine ();
		}
		$this->CI->load->library('session');
		$this->CI->session->set_userdata('captcha', $this->captcha);
		
		return $this->image; // 輸出
	}
	private function makeBorder() {
		$bgcolor = ImageColorAllocate ( $this->image, $this->bordercolor[0], $this->bordercolor[1], $this->bordercolor[2] ); // 邊框顏色
		ImageRectangle ( $this->image, 0, 0, $this->width - 1, $this->height - 1, $bgcolor ); // 製作邊框
	}
	private function mixedLine() {
		for($i = 0; $i < 5; $i ++) {
			$bordercolor = ImageColorAllocate ( $this->image, mt_rand ( 0, 255 ), mt_rand ( 0, 255 ), mt_rand ( 0, 255 ) ); // 干擾線條顏色
			ImageArc ( $this->image, mt_rand ( - 5, $this->width ), mt_rand ( - 5, $this->height ), mt_rand ( 20, 300 ), mt_rand ( 20, 200 ), 55, 44, $bordercolor ); // 寫入圖片
		}
	}
}
