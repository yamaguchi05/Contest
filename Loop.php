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

// 整形
// 同じ処理はメソッドに切り出す
// マジックナンバーは定数に置き換える
// 余裕があれば・・・
// 仕様３にチャレンジする
// （余裕ない場合は$this->end_number辺りを削除する

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
		// 数値の桁を計算
		self::digit($this->first_number);
		self::digit($this->end_number,false);
	}

	/**
	 * メインメソッド
	 * 1桁目をスキップし、桁数に応じて処理を分岐させる
	 */
	public function main()
	{
		// 1桁の場合、端数を計算し2桁までスキップする
		// TODO [仕様３]余裕がない場合は && 以降を削除する
		if ($this->first_number_length === 1 && $this->end_number_length > 1 ) {
			// 10に置き換える
			$this->first_number = self::replace_number($this->first_number, 10);
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

		// 4桁の場合
		if($this->first_number_length === 4){
			self::calculate_four_digits($this->first_number, $this->end_number, $this->total_count);
		}

		// 5桁の場合
		if($this->first_number_length === 5){
			self::calculate_five_digits($this->first_number, $this->end_number, $this->total_count);
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
	 * 目的の数値に置き換える
	 *
	 * @param int  $first_number    現状の数値
	 * @param int  $target_number   置き換えたい数値
	 * @param bool $bool     true : 置き換えたい値より現状の数値が小さいとき
	 *                      false : 置き換えたい値より現状の数値が大きいとき
	 * @return int $replaced_number 置き換えた数値
	 */
	private function replace_number($first_number, $target_number, $bool = true)
	{
		// 端数
		$fraction = 0;
		if ($bool === true) {
			$fraction = ($target_number - $first_number);
			return $first_number + $fraction;
		}else{
			$fraction = ($first_number - $target_number);
			return $first_number - $fraction;
		}
	}

	/**
	 * 2桁の場合
	 * 11以降は、11を加算していく
	 * 数値をループし、回文を出力する
	 *
	 * @param int $first_number 始まり数値
	 * @param int $end_number   終わり数値
	 * @param int $total_count  ループのトータルカウント
	 */
	private function calculate_two_digits($first_number, $end_number, $total_count)
	{
		// TODO [仕様３] 2桁で11以上の場合
		if ($first_number < 11){
			$first_number = self::replace_number($first_number, 11);
			echo($first_number . PHP_EOL);
		}

		$count = (100 / 11) - 2;
		for ($i = 0 ; $i < $count ; $i++) {
			// 文字列を反転させて、同じ場合は、回文とみなす
			$first_number = ($first_number + 11);
			$reverse_first_number = (int) strrev($first_number);
			if ($first_number === $reverse_first_number) {
				echo($first_number . PHP_EOL);
			}
			$this->total_count = $total_count++;
		}

		if ($first_number < 101){
			$this->first_number = self::replace_number($first_number, 101);
			echo($this->first_number . PHP_EOL);
		}

		// 数値の桁を計算
		self::digit($this->first_number);
	}

	/**
	 * 3桁の場合
	 * 数値をループし、回文を出力する
	 *
	 * @param int $first_number 始まり数値
	 * @param int $end_number   終わり数値
	 * @param int $total_count  ループのトータルカウント
	 */
	private function calculate_three_digits($first_number, $end_number, $total_count)
	{
		// 100から1000までの回文は101,111,121..,202,212..～999
		// 外側の数がおなじならおけ
		//for中：101にして9回まわして10タス（191）11足す（202）、9回まわす
		for ($j = 0 ; $j < 9 ; $j++) {
			//TODO 外メソッド希望
			for ($i = 0 ; $i < 9 ; $i++) {
				// 文字列を反転させて、同じ場合は、回文
				$first_number = ($first_number + 10);
				$reverse_first_number = (int) strrev($first_number);
				if ($first_number === $reverse_first_number) {
					// macで改行を確認するため：PHP_EOL
					echo($first_number . PHP_EOL);
				}
				$this->total_count = $total_count++;
			}

			$first_number = ($first_number + 11);
			// 1000以上だったら、調整してループ抜ける
			if ($first_number > 1000) {
				$first_number = self::replace_number($first_number, 1001, false);
				$this->first_number = $first_number;
			}
			// TODO回文チェック
			echo($first_number . PHP_EOL);
		}
		// 数値の桁を計算
		self::digit($this->first_number);
	}

	/**
	 * 4桁
	 * 数値をループし、回文を出力する
	 *
	 * @param int $first_number 始まり数値
	 * @param int $end_number   終わり数値
	 * @param int $total_count  ループのトータルカウント
	 */
	private function calculate_four_digits($first_number, $end_number, $total_count)
	{
		// 1000から10000までの回文は1001,1111,1221..,9009,9119,9999
		// 外側の数がおなじ、もしくは内側がおなじ
		//for中：1001にして9回まわして110タス（1111）
		//for外：11足す（2002）、9回まわす
		for ($j = 0 ; $j < 9 ; $j++) {
			//TODO 外メソッド希望
			for ($i = 0 ; $i < 9 ; $i++) {
				// 文字列を反転させて、同じ場合は、回文
				$first_number = ($first_number + 110);
				$reverse_first_number = (int) strrev($first_number);
				if ($first_number === $reverse_first_number) {
					// macで改行を確認するため：PHP_EOL
					echo($first_number . PHP_EOL);
				}
				$this->total_count = $total_count++;
			}

			$first_number = ($first_number + 11);
			// 1000以上だったら、調整してループ抜ける
			if ($first_number > 10000) {
				$first_number = self::replace_number($first_number, 10001, false);
				$this->first_number = $first_number;
			}
			// 回文チェック
			echo($first_number . PHP_EOL);
		}
		// 数値の桁を計算
		self::digit($this->first_number);
	}

	/**
	 * 5桁
	 * 数値をループし、回文を出力する
	 *
	 * @param int $first_number 始まり数値
	 * @param int $end_number   終わり数値
	 * @param int $total_count  ループのトータルカウント
	 */
	private function calculate_five_digits($first_number, $end_number, $total_count)
	{
		// 10000から99999までの回文は10001,10101,10201,11011,1221..,9009,9119,9999
		// 1-5,2-4がおなじ
		//for(i)：10001にして9回まわして100タス（10101）-最後10901
		//for(j)：110足す（11011）、9回まわす
		//for(k)：全体をまわす

		for ($k = 0 ; $k < 10 ; $k++) {

			for ($j = 0 ; $j < 9 ; $j++) {

				//TODO 外メソッド希望
				for ($i = 0 ; $i < 9 ; $i++) {
					// 文字列を反転させて、同じ場合は、回文
					$first_number = ($first_number + 100);
					$reverse_first_number = (int) strrev($first_number);
					if ($first_number === $reverse_first_number) {
						// macで改行を確認するため：PHP_EOL
						echo($first_number . PHP_EOL);
					}
					$this->total_count = $total_count++;
				//for(i)閉め
				}
				//for外
				//19991の次が20101になるので、1タス必要がある
				// はたしてどのタイミングなのか？メモ-i-9,j-0,k-1"
				if ($i === 9 && $j === 0 && $k === 1) {
					//TODO 確認してみる
					$first_number = ($first_number + 11);
					var_dump('20002への切り替え');
					echo($first_number . PHP_EOL);
					continue;
				}
//TODO 30003への切り替え
				if ($i === 9 && $j === 1 && $k === 2) {
					//TODO 確認してみる
					$first_number = ($first_number + 11);
					var_dump('30003への切り替え');
					echo($first_number . PHP_EOL);
					continue;
				}

//TODO 40004への切り替え
				if ($i === 9 && $j === 2 && $k === 3) {
					//TODO 確認してみる
					$first_number = ($first_number + 11);
					var_dump('40004への切り替え');
					echo($first_number . PHP_EOL);
					continue;
				}

//TODO 50005への切り替え
				if ($i === 9 && $j === 3 && $k === 4) {
					//TODO 確認してみる
					$first_number = ($first_number + 11);
					var_dump('50005への切り替え');
					echo($first_number . PHP_EOL);
					continue;
				}

//TODO 60006への切り替え
				if ($i === 9 && $j === 4 && $k === 5) {
					//TODO 確認してみる
					$first_number = ($first_number + 11);
					var_dump('60006への切り替え');
					echo($first_number . PHP_EOL);
					continue;
				}

//TODO 70007への切り替え
				if ($i === 9 && $j === 5 && $k === 6) {
					//TODO 確認してみる
					$first_number = ($first_number + 11);
					var_dump('70007への切り替え');
					echo($first_number . PHP_EOL);
					continue;
				}


//TODO 80008への切り替え
				if ($i === 9 && $j === 6 && $k === 7) {
					//TODO 確認してみる
					$first_number = ($first_number + 11);
					var_dump('80008への切り替え');
					echo($first_number . PHP_EOL);
					continue;
				}

//TODO 90009への切り替え
				if ($i === 9 && $j === 7 && $k === 8) {
					//TODO 確認してみる
					$first_number = ($first_number + 11);
					var_dump('90009への切り替え');
					echo($first_number . PHP_EOL);
					continue;
				}


				$first_number = ($first_number + 110);
				$reverse_first_number = (int) strrev($first_number);
				if ($first_number === $reverse_first_number) {
					// macで改行を確認するため：PHP_EOL
					echo($first_number . PHP_EOL);
				}
			//for(j)閉め
			}
		//for(k)閉め
		}
		//TODO
		var_dump('5けた');
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