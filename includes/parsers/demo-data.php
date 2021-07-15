<?php


class Demo_Data {

	private static function data(): array {
		return array(
			'neon' => array(
				'url' => 'https://neon.ua/product/_AMD_AM4_Ryzen_5_5600X_Tray_6x3_7_GHz_Turbo_Boost_4_6_GHz_L3_32Mb_Zen_3_7_nm_TDP_65W_100100000065__924998/',
				'xpath' => '//*[contains(@class, "price-2")]/span',
				'substr_start' => '<span itemprop="price">',
				'substr_end' => '</span>'
			)
		);
	}

	public static function get( $select ) {
		$demo = self::data();

		if ( ! isset( $demo[ $select ] ) )
			return false;

		return $demo[ $select ];
	}

}