<?php

namespace CoinMarketCap;
use Httpful\Request;

class Base
{
    /**
     * @var string
     */
    const BASE_URL = 'https://api.coinmarketcap.com/v1/';

    function __construct()
    {
        $template = Request::init()->sendsJson()->expectsJson();
        Request::ini($template);
    }
    
    /**
     * @param array $params
     * @return array
     */
    public function getTicker($params = array())
    {
        return $this->_buildRequest('ticker', $params);
    }

    /**
     * @param $coinId
     * @param array $params
     * @return array
     */
    public function getTickerByCoin($coinId, $params = array())
    {
        return $this->_buildRequest('ticker/' . $coinId, $params);
    }

    /**
     * @param array $params
     * @return array
     */
    public function getGlobalData($params = array())
    {
        return $this->_buildRequest('global', $params);
    }

    /**
     * @param $endpoint
     * @param array $params
     * @return array
     */
    private function _buildRequest($endpoint, $params = array())
    {
        
        $response = $this->_request(self::BASE_URL . $endpoint, $params);
        return $response;
    }

    /**
     * @param $url
     * @param array $params
     * @return string
     */
    private function _request($url, $params = array())
    {
        try
        {
            $response = Request::get( $url . '?' . http_build_query($params) )->send();
            if( !$response->body )
            {
                throw new Exception('Error in petition');
            }
            return $response->body;
            
        } catch (Exception $ex) {
            return false;
        }
    }
}
