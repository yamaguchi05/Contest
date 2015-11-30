<?php
/**
 * プログラミングコンテスト
 * メイン処理（ひねる）
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
class Loop
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
			// 10に設定しておく
			$fraction = (10 - $this->first_number);
			$this->first_number = $this->first_number + $fraction;
			// TODO 数値の桁を計算
			self::digit($this->first_number);
		}

		// 2桁の場合
		if($this->first_number_length === 2){
			self::calculate_two_digits($this->first_number, $this->end_number, $this->total_count);
		}

		// 3桁の場合
		if($this->first_number_length === 3){
			self::calculate_three_digits($this->first_number, $this->end_number, $this->total_count);
		}
		//　最後に出力
		print("トータルカウント : $this->total_count" . PHP_EOL);
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
	 * 2桁
	 * 数値をループし、回文を出力する
	 *
	 * @param int $first_number 始まり数値
	 * @param int $end_number   終わり数値
	 * @param int $total_count  ループのトータルカウント
	 */
	private function calculate_two_digits($first_number, $end_number, $total_count)
	{
		// 10から100までの回文は11～99
		// 11のあとは+11していって、出力する

		// 11に調整
		// ※2桁で11以上の場合の処理は余裕があれば考える
		if ($first_number < 11){
			$fraction = (11 - $first_number);
			$first_number = $first_number + $fraction;
			echo($first_number . PHP_EOL);
		}

		$count = (100 / 11) - 2;
		for ($i = 0 ; $i < $count ; $i++) {
			// 文字列を反転させて、同じ場合は、回文
			$first_number = ($first_number + 11);
			$reverse_first_number = (int) strrev($first_number);
			if ($first_number === $reverse_first_number) {
				// macで改行を確認するため：PHP_EOL
				echo($first_number . PHP_EOL);
			}
			$this->total_count = $total_count++;
		}

		// 100に調整 ※調整メソッドは別だししたいけど一旦かいとく
		if ($first_number < 100){
			$fraction = (100 - $first_number);
			$this->first_number = $first_number + $fraction;
		}

		// TODO 数値の桁を計算
		self::digit($this->first_number);
	}

	/**
	 * 3桁
	 * 数値をループし、回文を出力する
	 *
	 * @param int $first_number 始まり数値
	 * @param int $end_number   終わり数値
	 * @param int $total_count  ループのトータルカウント
	 */
	private function calculate_three_digits($first_number, $end_number, $total_count)
	{
		// 100から1000までの回文は101,111,121～999
		// 外側の数がおなじならおけ
		var_dump('3けた');
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
	}


}