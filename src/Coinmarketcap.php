<?php

namespace CoinMarketCap;
use Httpful\Request;

class Coinmarketcap
{
    /**
     * @var string
     */
    private $base_url = 'https://pro-api.coinmarketcap.com/%s/';
    private $version = 'v1';
    private $key = null;

    function __construct( $key )
    {
        if( $key )
        {
            $this->key = $key;
        }
        
        $this->base_url = \sprintf( $this->base_url, $this->version );
        $template = Request::init()->sendsJson()->expectsJson();
        Request::ini($template);
    }
    
    public function setVersion( $version = 'v1' )
    {
        $this->version = $version;
    }

    public function setKey( $key )
    {
        $this->key = $key;
    }

    /**
     * @param null $limit
     * @param null $start
     * @param null $convert
     * @return array
     */
    public function getLatest( $limit, $start, $convert )
    {
        return $this->_buildRequest( 'cryptocurrency/listings/latest', array( 'limit' => $limit, 'start' => $start, 'convert' => $convert ) );
    }

    /**
     * @param string $id
     * @param string $convert
     * @return array
     */
    public function getTicker( string $id, $convert = null )
    {
        return $this->_buildRequest( 'ticker/' . $id, array( 'convert' => $convert ) );
    }

    /**
     * @param null $convert
     * @return array
     */
    public function getGlobal( $convert = null )
    {
        return $this->_buildRequest('global-metrics/quotes/latest', array( 'convert' => $convert ) );
    }

    /**
     * @param $endpoint
     * @param array $params
     * @return array
     */
    private function _buildRequest( $endpoint, $params = array() )
    {
        $response = $this->_request($this->base_url . $endpoint, $params);
        return $response;
    }


    /**
     * @param $id
     * @param $convert
     * @return mixed
     * @throws \Rentberry\Coinmarketcap\Exception
     */
    public function getExchangeRate( $id, $convert )
    {
        $ticker = $this->getTicker( $id, $convert );
        $priceKey = \sprintf( 'price_%s', \strtolower( $convert ) );
        if (!\array_key_exists( $priceKey, $ticker ) || $ticker[ $priceKey ] === 0 )
        {
            throw new Exception( 'Invalid currency ticker' );
        }

        return (string) $ticker[$priceKey];
    }


    /**
     * @param int|float|string $amount
     * @param string $from
     * @param string $id
     * @param int $scale
     * @return string
     * @throws \Rentberry\Coinmarketcap\Exception
     */
    public function convertToCrypto( $amount, string $from, string $id, int $scale = 18 )
    {
        $rate = $this->getExchangeRate( $id, $from );
        return \bcdiv( (string) $amount, $rate, $scale );
    }


    /**
     * @param float $amount
     * @param string $id
     * @param string $to
     * @param int $scale
     * @return string
     * @throws \Rentberry\Coinmarketcap\Exception
     */
    public function convertToFiat( $amount, string $id, string $to, int $scale = 4 )
    {
        $rate = $this->getExchangeRate( $id, $to );
        return \bcmul( (string) $amount, $rate, $scale );
    }

    /**
     * @param $url
     * @param array $params
     * @return string
     */
    private function _request($url, $params = array())
    {
        $url = (count( $params ) > 0 ) ? $url . '?' . http_build_query( $params ) : $url;
        $response = Request::get( $url )->addHeader( 'X-CMC_PRO_API_KEY', $this->key )->send();

        if( !$response->body )
        {
            throw new Exception('Error in petition');
        }

        return $response->body;
    }
}
