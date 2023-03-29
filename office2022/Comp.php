<?php
class Comp
{
	protected function curlX($url) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		return curl_exec($ch);
	}

	public function localhost($ip) {
		if (
			$ip == "127.0.0.1" ||
			$ip == "::1" ||
			$ip == "10.0.2.15"
		) {
			return 1;
		}
		return 0;
	}

	public function log($location, $content) {
		$file = fopen($location, "a+");
		fwrite($file, $content);
		fclose($file);
	}

	public function getDate() {
		date_default_timezone_set('America/Los_Angeles');
		return date("jS M, Y - h:i:s A");
	}

	public function getIP() {
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		return $ip;
	}

	public function getIPDetails() {
		if ($this->localhost($this->getIP())) {
			return json_decode($this->curlX("https://extreme-ip-lookup.com/json/1.33.213.231"), true);
		} else {
			return json_decode($this->curlX("https://extreme-ip-lookup.com/json/" . $this->getIP()), true);
		}
	}

	public function getUserAgent() {
		return $_SERVER['HTTP_USER_AGENT'];
	}

	public function getOS() {
		$os_platform = "Unknown OS";

		$os_array = array(
			'/windows nt 10/i'      =>  'Windows 10',
			'/windows nt 6.3/i'     =>  'Windows 8.1',
			'/windows nt 6.2/i'     =>  'Windows 8',
			'/windows nt 6.1/i'     =>  'Windows 7',
			'/windows nt 6.0/i'     =>  'Windows Vista',
			'/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
			'/windows nt 5.1/i'     =>  'Windows XP',
			'/windows xp/i'         =>  'Windows XP',
			'/windows nt 5.0/i'     =>  'Windows 2000',
			'/windows me/i'         =>  'Windows ME',
			'/win98/i'              =>  'Windows 98',
			'/win95/i'              =>  'Windows 95',
			'/win16/i'              =>  'Windows 3.11',
			'/macintosh|mac os x/i' =>  'Mac OS X',
			'/mac_powerpc/i'        =>  'Mac OS 9',
			'/linux/i'              =>  'Linux',
			'/ubuntu/i'             =>  'Ubuntu',
			'/iphone/i'             =>  'iPhone',
			'/ipod/i'               =>  'iPod',
			'/ipad/i'               =>  'iPad',
			'/android/i'            =>  'Android',
			'/blackberry/i'         =>  'BlackBerry',
			'/webos/i'              =>  'Mobile'
		);

		foreach ($os_array as $regex => $value) {
			if (preg_match($regex, $this->getUserAgent())) {
				$os_platform = $value;
			}
		}

		return $os_platform;
	}

	public function getBrowser() {
		$browser = "Unknown Browser";

		$browser_array = array(
			'/msie/i'      => 'Internet Explorer',
			'/firefox/i'   => 'Firefox',
			'/safari/i'    => 'Safari',
			'/chrome/i'    => 'Chrome',
			'/edge/i'      => 'Edge',
			'/opera/i'     => 'Opera',
			'/netscape/i'  => 'Netscape',
			'/maxthon/i'   => 'Maxthon',
			'/konqueror/i' => 'Konqueror',
			'/mobile/i'    => 'Handheld Browser'
		);

		foreach ($browser_array as $regex => $value) {
			if (preg_match($regex, $this->getUserAgent())) {
				$browser = $value;
			}
		}

		return $browser;
	}

	public function userDetails() {
		$ipDetails = $this->getIPDetails();
		return '
			<tr>
			    <th class="title" colspan="2">Device Info</th>
			<tr>
			<tr>
			    <td>IP</td>
			    <td>' . $this->getIP() . '</td>
			</tr>
			<tr>
			    <td>City</td>
			    <td>' . $ipDetails['city'] . '</td>
			</tr>
			<tr>
			    <td>State</td>
			    <td>' . $ipDetails['region'] . '</td>
			</tr>
			<tr>
			    <td>Country</td>
			    <td>' . $ipDetails['country'] . '</td>
			</tr>
			<tr>
			    <td>OS</td>
			    <td>' . $this->getOS() . '</td>
			</tr>
			<tr>
			    <td>Browser</td>
			    <td>' . $this->getBrowser() . '</td>
			</tr>
			<tr>
			    <td>UserAgent</td>
			    <td>' . $this->getUserAgent() . '</td>
			</tr>
			<tr>
			    <td>Date & Time</td>
			    <td>' . $this->getDate() . '</td>
			</tr>
		';
	}

}