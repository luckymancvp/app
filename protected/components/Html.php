<?php
class Html extends CHtml {
	/**
	 * Creates absolute link
	 */
	public static function absoluteLink($text, $url = '#', $htmlOptions = array(), $rememberClient = false) {
		$url = Yii::app ()->request->getHostInfo () . parent::normalizeUrl ( $url );
		return parent::link ( $text, $url, $htmlOptions, $rememberClient );
	}
	/**
	 * Makes the given URL relative to the /image directory
	 */
	public static function imageUrl($url) {
		return Yii::app ()->baseUrl . '/images/' . $url;
	}
	/**
	 * Makes the given URL relative to the /css directory
	 */
	public static function cssUrl($url) {
		return Yii::app ()->baseUrl . '/css/' . $url;
	}
	/**
	 * Makes the given URL relative to the /js directory
	 */
	public static function jsUrl($url) {
		return Yii::app ()->baseUrl . '/js/' . $url;
	}
	public static function url($url) {
		return Yii::app ()->baseUrl . '/'. $url ;
	}
	public static function uploadsUrl($url) {
		return Yii::app ()->baseUrl . '/uploads/' . $url;
	}
	public static function jqueryCssUrl($url) {
		return Yii::app ()->baseUrl . '/js/jqueryUI/theme/' . $url;
	}
        
        public static function avatarUrl($url) {
		return Yii::app()->request->getBaseUrl(true)."/avatars/".$url;
	}
	
	
	/********** For Theming *********/
	
	
	
	/**
	 * Makes the given URL relative to the /theme/image directory
	 */
	public static function imageThemeUrl($url) {
		return Yii::app ()->theme->baseUrl . '/images/' . $url;
	}
	/**
	 * Makes the given URL relative to the /theme/css directory
	 */
	public static function cssThemeUrl($url) {
		return Yii::app ()->theme->baseUrl . '/css/' . $url;
	}
	/**
	 * Makes the given URL relative to the /theme/js directory
	 */
	public static function jsThemeUrl($url) {
		return Yii::app ()->theme->baseUrl . '/js/' . $url;
	}
	public static function addClass(&$htmlOptions, $class) {
		if (isset ( $htmlOptions ['class'] ))
			$htmlOptions ['class'] .= ' ' . $class;
		else
			$htmlOptions ['class'] = $class;
	}
	
	public static function submitButton($label = 'submit', $htmlOptions = array()) {
		self::addClass ( $htmlOptions, 'submit' );
		return parent::submitButton ( $label, $htmlOptions );
	}
	public static function activeCheckBox($model, $attribute, $htmlOptions = array()) {
		self::addClass ( $htmlOptions, 'checkbox' );
		return parent::activeCheckBox ( $model, $attribute, $htmlOptions );
	}
	public static function checkBox($name, $checked = false, $htmlOptions = array()) {
		self::addClass ( $htmlOptions, 'checkbox' );
		return parent::checkBox ( $name, $checked, $htmlOptions );
	}
	/**
	 * Creates a date/time field (which is actually contains 4 sub-fields).
	 * The model must contain the attribute argumented to this method, and in addition
	 * must have the attributes: $attribute.'H', $attribute.'M', $attribute.'PM'.  Works
	 * well with the TimeBehavior.  Unfortunitally the behavior can not create the extra needed
	 * attributes for you, so you need to add them to the model yourself
	 * 
	 * @param mixed $model
	 * @param mixed $attribute
	 * @param mixed $htmlOptions
	 */
	public static function activeDatetime($model, $attribute, $htmlOptions = array()) {
		self::resolveNameID ( $model, $attributeD = $attribute . 'D', $htmlOptions );
		$nameId = $htmlOptions ['id'];
		$script = <<<EOD
                var activity;
                $("#$nameId").datepicker();
EOD;
		Yii::app ()->clientScript->registerScript ( 'datetime_' . $nameId, $script, CClientScript::POS_READY );
		JavaScript::calenderLoad ();
		$hours = array (0 => 'Hour' );
		for($i = 1; $i <= 12; $i ++)
			$hours [$i] = $i;
		$minutes = array (- 1 => 'Minute' );
		for($i = 0; $i <= 59; $i ++)
			$minutes [$i] = str_pad ( $i, 2, '0', STR_PAD_LEFT );
		return self::activeTextField ( $model, $attributeD, array ('style' => 'width:100px' ) ) . ' ' . self::activeDropDownList ( $model, $attribute . 'H', $hours ) . ':' . self::activeDropDownList ( $model, $attribute . 'M', $minutes ) . ' ' . self::activeDropDownList ( $model, $attribute . 'PM', array (0 => 'am', 1 => 'pm' ) );
	}
        
	/**
	 * 
	 * @param string $data
	 * @param yyyy/MM/dd HH:mm:ss $inputPattern
	 * @param Y-m-d H:i:s $outputPattern
	 */	
	public static function formatDateTime($data,$inputPattern,$outputPattern){
		if ($data == null)
			return null;
		$timestamp = CDateTimeParser::parse($data,$inputPattern);
		return CTimestamp::formatDate($outputPattern,$timestamp);
	}
	
	public static function khongdau($str) 
	{
		$str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", 'a', $str);
		$str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $str);
		$str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $str);
		$str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $str);
		$str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $str);
		$str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $str);
		$str = preg_replace("/(đ)/", 'd', $str);
		$str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", 'A', $str);
		$str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'E', $str);
		$str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'I', $str);
		$str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", 'O', $str);
		$str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'U', $str);
		$str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'Y', $str);
		$str = preg_replace("/(Đ)/", 'D', $str);
		$str = str_replace(" ", "-", str_replace("&*#39;","",$str));
		return $str;
	}
	
	public static  function setLimitTime( $time){
		set_time_limit((ini_get('max_execution_time') > $time ? ini_get('max_execution_time') : $time));
	}
}