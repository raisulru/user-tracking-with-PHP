<?php
/**
 * Created by PhpStorm.
 * User: Dragan
 * Date: 26.3.15
 * Time: 23:34
 */
include ('VisitorsCon.php');
class Visitors {
    private $server_time;
    private $server_date;
    private $timeZone;

    private $user_ip;
    private $user_os;
    private $user_browser;
    private $userAgent;

    private $userCountry;
    private $userCountryCode;
    private $userCity;
    private $userStateOfRegion;
    private $latitude;
    private $longitude;

    private $ISP;
    private $ORG;
    private $AS;

    private $subdomain;

    function __construct()
    {

        $this->init();
    }

    function init()
    {
        $this->AS = '';
        $this->ISP = '';
        $this->ORG = '';
        $this->latitude = '';
        $this->longitude = '';
        $this->server_date = '';
        $this->server_time = '';
        $this->subdomain = '';
        $this->userAgent = '';
        $this->userCity = '';
        $this->userCountry = '';
        $this->userCountryCode = '';
        $this->userStateOfRegion = '';
        $this->user_browser = '';
        $this->user_ip = '';
        $this->user_os = '';
        $this->timeZone='';
        $this->subdomain='';
    }

    function getVisitorInfo($httpUserAgent)
    {
        $this->setUserIp();
        $this->setServerDate();
        $this->setServerTime();
        $this->setUserOs($httpUserAgent);
        $this->setUserBrowser($httpUserAgent);
        $this->setUserAgent($httpUserAgent);
        $query = @unserialize(file_get_contents('http://ip-api.com/php/'.$this->getUserIp()));
        $this->setUserCountry($query['country']);
        $this->setUserCountryCode($query['countryCode']);
        $this->setUserCity($query['city']);
        $this->setUserStateOfRegion($query['regionName']);
        $this->setLatitude($query['lat']);
        $this->setLongitude($query['lon']);
        $this->setISP($query['isp']);
        $this->setORG($query['org']);
        $this->setAS($query['as']);
        $this->setTimeZone($query['timezone']);

    }

    function insertInfo()
    {
        try
        {
            $db=new DBConnect();
            $conection = $db->connectDatabase();


           $qry=("INSERT INTO visitors (domain, ip, serverDate, serverTime, timeZone, userOS, userBrowser,
             userAgent, country, countryCode, city, state, lat, lon, isp, org,  asp)
             VALUES ('".$this->getSubdomain()."', '".$this->getUserIp()."', '".$this->getServerDate()."', '".$this->getServerTime()."', '".$this->getTimeZone()."',
              '".$this->getUserOs()."', '".$this->getUserBrowser()."', '".$this->getUserAgent()."', '".$this->getUserCountry()."',
               '".$this->getUserCountryCode()."', '".$this->getUserCity()."', '".$this->getUserStateOfRegion()."',
                '".$this->getLatitude()."', '".$this->getLongitude()."', '".$this->getISP()."', '".$this->getORG()."', '".$this->getAS()."')");
            if(!mysqli_query($conection, $qry))
            {
                $db->CloseDataBaseConncection();
                throw new Exception(mysqli_error($conection));
            }
            $db->CloseDataBaseConncection();

        }
        catch(Exception $e)
        {
            echo $e->getMessage();
        }

    }



    /**
     * @param mixed $server_date
     */
    public function setServerDate()
    {
        $this->server_date = Date('Y-m-d');
    }

    /**
     * @return mixed
     */
    public function getServerDate()
    {
        return $this->server_date;
    }

    /**
     * @param mixed $server_time
     */
    public function setServerTime()
    {
        $this->server_time = Date('H:i:s', strtotime('+1 hour'));
    }

    /**
     * @return mixed
     */
    public function getServerTime()
    {
        return $this->server_time;
    }

    /**
     * @param mixed $subdomain
     */
    public function setSubdomain($subdomain)
    {
        $this->subdomain = $subdomain;
    }

    /**
     * @return mixed
     */
    public function getSubdomain()
    {
        return $this->subdomain;
    }

    /**
     * @param mixed $userAgent
     */
    public function setUserAgent($userAgent)
    {
        $this->userAgent = $userAgent;
    }

    /**
     * @return mixed
     */
    public function getUserAgent()
    {
        return $this->userAgent;
    }


    /**
     * @param mixed $user_browser
     */
    public function setUserBrowser($user_browser)
    {
        $this->user_browser = self::getBrowser($user_browser);
    }

    /**
     * @return mixed
     */
    public function getUserBrowser()
    {
        return $this->user_browser;
    }


    /**
     * @param mixed $user_ip
     */
    public function setUserIp()
    {
        $this->user_ip = self::getRealIpAddr();
    }

    /**
     * @return mixed
     */
    public function getUserIp()
    {
        return $this->user_ip;
    }

    /**
     * @param mixed $user_os
     */
    public function setUserOs($httpUserAgent)
    {
        $this->user_os = self::getOS($httpUserAgent);
    }

    /**
     * @return mixed
     */
    public function getUserOs()
    {
        return $this->user_os;
    }

    /**
     * @param mixed $AS
     */
    public function setAS($AS)
    {
        $this->AS = $AS;
    }

    /**
     * @return mixed
     */
    public function getAS()
    {
        return $this->AS;
    }

    /**
     * @param mixed $ISP
     */
    public function setISP($ISP)
    {
        $this->ISP = $ISP;
    }

    /**
     * @return mixed
     */
    public function getISP()
    {
        return $this->ISP;
    }

    /**
     * @param mixed $ORG
     */
    public function setORG($ORG)
    {
        $this->ORG = $ORG;
    }

    /**
     * @return mixed
     */
    public function getORG()
    {
        return $this->ORG;
    }

    /**
     * @param mixed $latitude
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    }

    /**
     * @return mixed
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @param mixed $longitude
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
    }

    /**
     * @return mixed
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @param mixed $timeZone
     */
    public function setTimeZone($timeZone)
    {
        $this->timeZone = $timeZone;
    }

    /**
     * @return mixed
     */
    public function getTimeZone()
    {
        return $this->timeZone;
    }

    /**
     * @param mixed $userCity
     */
    public function setUserCity($userCity)
    {
        $this->userCity = $userCity;
    }

    /**
     * @return mixed
     */
    public function getUserCity()
    {
        return $this->userCity;
    }

    /**
     * @param mixed $userCountry
     */
    public function setUserCountry($userCountry)
    {
        $this->userCountry = $userCountry;
    }

    /**
     * @return mixed
     */
    public function getUserCountry()
    {
        return $this->userCountry;
    }

    /**
     * @param mixed $userCountryCode
     */
    public function setUserCountryCode($userCountryCode)
    {
        $this->userCountryCode = $userCountryCode;
    }

    /**
     * @return mixed
     */
    public function getUserCountryCode()
    {
        return $this->userCountryCode;
    }

    /**
     * @param mixed $userStateOfRegion
     */
    public function setUserStateOfRegion($userStateOfRegion)
    {
        $this->userStateOfRegion = $userStateOfRegion;
    }

    /**
     * @return mixed
     */
    public function getUserStateOfRegion()
    {
        return $this->userStateOfRegion;
    }



    function getRealIpAddr()
    {
        if (isset($_SERVER['REMOTE_ADDR']) and $_SERVER['REMOTE_ADDR'] != '')
        {
            return $_SERVER['REMOTE_ADDR'];
        }
        // Fall back to HTTP_CLIENT_IP
        elseif (isset($_SERVER['HTTP_CLIENT_IP']) and $_SERVER['HTTP_CLIENT_IP'] != '')
        {
            return $_SERVER['HTTP_CLIENT_IP'];
        }
        // Finally fall back to HTTP_X_FORWARDED_FOR
        // I'm aware this can sometimes pass the users LAN IP, but it is a last ditch attempt
        elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR']) and $_SERVER['HTTP_X_FORWARDED_FOR'] != '')
        {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        }

        // Nothing? Return false
        return false;
    }

    function getOS($user_agent)
    {

        $os_platform    =   "Unknown OS Platform";
        $os_array       =   array(
            '/windows nt 10/i'     =>  'Windows 10',
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

        foreach ($os_array as $regex => $value)
        {
            if (preg_match($regex, $user_agent))
            {
                $os_platform=$value;
            }
        }
        return $os_platform;
    }

    function getBrowser($user_agent)
    {
        $browser        =   "Unknown Browser";
        $browser_array  =   array(
            '/msie/i'       =>  'Internet Explorer',
            '/firefox/i'    =>  'Firefox',
            '/safari/i'     =>  'Safari',
            '/chrome/i'     =>  'Chrome',
            '/opera/i'      =>  'Opera',
            '/netscape/i'   =>  'Netscape',
            '/maxthon/i'    =>  'Maxthon',
            '/konqueror/i'  =>  'Konqueror',
            '/mobile/i'     =>  'Handheld Browser'
        );
        foreach ($browser_array as $regex => $value)
        {
            if (preg_match($regex, $user_agent))
            {
                $browser=$value;
            }
        }
        return $browser;
    }

}