<?php
/**
 * プログラミングコンテスト
 * メイン処理
 */

/*
 * 要件 1~99999の数値の中で回文になっている数値を出力する
 * 
 * 仕様
 * １数値は小さい順に出力すること
 * ２1桁は回文とみなさない
 * ３最小値と最大値は任意の値をしていしてもいい
 * ４ちゃんとプログラムの中で計算すること
 * ５プログラム中の全ループ回数出力すること
 * 
 */

// 自分的な設計めも
// よく出る数値があるなら定数ファイルをもつ
// メソッドで区切って最後に出力はなしなのか、確認する
// 計算、出力の繰り返しにはなると思う
// 出力方法はおいておいて最初に計算を考える

require_once(DIR_PATH . '/' . 'const.php');

/**
 * 回文を作成し、出力するクラス
 */
class Palindrome
{
	public $first_number = 0;
	public $first_number_length = 0;
	public $end_number = 0;
	public $end_number_length = 0;
	public $total_count = 0;

	/**
	 * コンストラクタ
	 */
	public function __construct()
	{
		// 引数チェック
		if(isset($_SERVER['argv'][INDEX_FIRST_NUMBER]) === false ||
		isset($_SERVER['argv'][INDEX_END_NUMBER]) === false){
			exit('引数を2つ指定してください');
		}
		$this->first_number = $_SERVER['argv'][INDEX_FIRST_NUMBER];
		$this->end_number = $_SERVER['argv'][INDEX_END_NUMBER];
		// TODO 数値の桁を計算
		self::digit($this->first_number);
		self::digit($this->end_number,false);
	}

	/**
	 * 名前はとりあえず、仮で。。
	 * メイン
	 */
	public function main()
	{
		// 端数
		$fraction = 0;
		// 1桁の場合、端数を計算し2桁までスキップする
		if ($this->first_number_length === 1 && $this->end_number_length > 1 ) {
			// 11に設定しておく(ルール的に微妙)
			$fraction = (11 - $this->first_number);
			$this->first_number = $this->first_number + $fraction;
			// TODO 数値の桁を計算
			self::digit($this->first_number);
		}

		// 2桁以上の場合
		if($this->first_number_length === 2 || $this->first_number_length > 2 ){
			self::calculate_digits($this->first_number, $this->end_number, $this->total_count);
		}
	}

	/**
	 * 数値の桁をメンバ変数にもたせる
	 *
	 * @param int $number 数値
	 * @param boolean trueの場合  first_number
	 *                falseの場合 end_number
	 */
	private function digit($number, $bool = true)
	{
		if ($bool === true) {
			$this->first_number_length = strlen($number);
		}else{
			$this->end_number_length = strlen($number);
		}
	}

	/**
	 * 数値をループし、回文を出力する
	 *
	 * @param int $first_number 始まり数値
	 * @param int $end_number   終わり数値
	 * @param int $total_count  ループのトータルカウント
	 */
	private function calculate_digits($first_number, $end_number, $total_count)
	{
		// 最後の文字も出力させるために
		$end_number += 1;
		for ($first_number; $first_number < $end_number; $first_number++) {
			// 文字列を反転させて、同じ場合は、回文
			$reverse_first_number = (int) strrev($first_number);
			if ($first_number === $reverse_first_number) {
				// macで改行を確認するため：PHP_EOL
				echo($first_number . PHP_EOL);
			}
			$this->total_count = $total_count++;
		}
		print("トータルカウント : $this->total_count" . PHP_EOL);

		//first_number +11をいれまくった配列を作成
		//配列の大きさの分だけforでループして出力する

		// self::digit($this->end_number,false);
		// // 終わり数値が2桁より大きいの場合
		// 上のforを外メソッド化しておく
		// if ($this->end_number_length > 2) {
		// }else{
		// 	// 終わり数値が2桁の場合-余裕があれば
		// }
	}


}