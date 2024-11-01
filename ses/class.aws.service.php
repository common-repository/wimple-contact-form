<?php
/**
Copyright (c) 2020, SARANGSoft.

AWSServiceForWP is a PHP class written for calling AWS Simple Email Service (SES) API with signature version 4 using WordPress HTTP function.
*/

class AWSServiceForWP
{
	const SERVICE 	  = "email";				// The AWS Service to use
	
    const DOMAIN 	  = "amazonaws.com";		// AWS Service domain name
	
    const ALGORITHM   = "AWS4-HMAC-SHA256";	    // Alogorithm used to create signature version 4
	
	const METHOD	  = "GET";				    // AWS Service call method, Always use GET
	
	const TIMEOUT	  = "45";					// AWS Service call wait time for a response
	
	const REDIRECTION = "5";					// AWS Service call wait time for a redirection

	const HTTPVERSION = "1.1";				    // AWS Service call HTTP protocol version
	
    private $AWSAccessKey;         				// AWS Access key
    
    private $AWSSecretKey;         				// AWS Secret key
	
	private $AWSServiceRegion;					// AWS Region
    
    private $AWSServiceHost;    				// AWS Service host (derived property)
	
	private $AWSServiceEndpoint;				// AWS Service call URL (derived property)
	
	private $xAmzDate;							// AWS date that is used to create the signature (derived property)
	
    private $GMTDate;							// GMT date (YYYYMMDD format, derived property)
	
	private $AWSServiceCallHeaders;				// AWS Service call headers (derived property)
    
    private $AWSServiceCallQuery;				// AWS Service call query parameters
	
	private $AWSServiceResponse;				// AWS Service response (XML)
	
	/**
    * Constructor
    *
    * @param string $accessKey 	AWS access key
	* @param string $secretKey 	AWS secret key
    * @param string $region 	AWS region. Default 'us-east-1'
	*
    * @return void
    */
    public function __construct( $accessKey = NULL, $secretKey = NULL, $region = 'us-east-1' )
    {
        if ( $accessKey !== NULL &&
     		 trim( $accessKey ) != "" && 
			 $secretKey !== NULL && 
			 trim( $secretKey ) != "" && 
			 $region !== NULL & 
			 trim( $region ) != "" )
        {
            $this->AWSAccessKey 	  = $accessKey;
			
			$this->AWSSecretKey 	  = $secretKey;
            
            $this->AWSServiceRegion   = $region;
			
			$this->AWSServiceHost 	  = self::SERVICE . '.' . $this->AWSServiceRegion . '.' . self::DOMAIN;
			
			$this->AWSServiceEndpoint = 'https://' . self::SERVICE . '.' . $this->AWSServiceRegion . '.' . self::DOMAIN;
        }
    }

	/**
     * Generate and returns binary hmac sha256
     *
     * @return hmac sha256.
     */
    private function generateSignatureKey()
    {
        $dateHash 	 = hash_hmac( 'sha256', $this->GMTDate, utf8_encode( "AWS4" . $this->AWSSecretKey ), true );
		
        $regionHash  = hash_hmac( 'sha256', $this->AWSServiceRegion, $dateHash, true );
		
        $serviceHash = hash_hmac( 'sha256', self::SERVICE, $regionHash, true );
		
        $signingHash = hash_hmac( 'sha256', 'aws4_request', $serviceHash, true );

        return $signingHash;
    }
	
    private function createAWSCallHeaders()
	{
		##### Start Task 1 #####
		$canonicalUri 	  = '/';
		
		$canonicalHeaders = "host:" . $this->AWSServiceHost . "\n" . "x-amz-date:" . $this->xAmzDate . "\n";
		
		$signedHeaders 	  = "host;x-amz-date";
		
		$payloadHash 	  = hash( 'sha256', '' );
		
		$canonicalRequest = self::METHOD . "\n" . $canonicalUri . "\n" . $this->AWSServiceCallQuery . "\n" . $canonicalHeaders . "\n" . $signedHeaders . "\n" . $payloadHash;
		###### End Task 1 ######
		
		##### Start Task 2 #####
		$credentialScope = $this->GMTDate . '/' . $this->AWSServiceRegion . '/' . self::SERVICE . '/aws4_request';
		
        $stringToSign 	 =  self::ALGORITHM . "\n" . $this->xAmzDate . "\n" . $credentialScope . "\n" . hash( 'sha256', $canonicalRequest );
		###### End Task 2 ######
		
		##### Start Task 3 #####
		$signingKey = $this->generateSignatureKey();
		
		$signature 	= hash_hmac( 'sha256', $stringToSign, $signingKey );
		###### End Task 3 ######
		
		$this->AWSServiceCallHeaders['Date'] 	      = $this->GMTDate;
		
		$this->AWSServiceCallHeaders['Host'] 	      = $this->AWSServiceHost;
		
		$this->AWSServiceCallHeaders['Content-Type']  = 'application/x-www-form-urlencoded; charset=utf-8';
		
		$this->AWSServiceCallHeaders['Accept']  	  = 'application/json';
		
		$this->AWSServiceCallHeaders['x-amz-date']    = $this->xAmzDate;
		
		$this->AWSServiceCallHeaders['Authorization'] = self::ALGORITHM . ' Credential=' . $this->AWSAccessKey . '/' . $credentialScope . ', SignedHeaders=' . $signedHeaders . ', Signature=' . $signature;
	}
	
	/**
     * Refresh AWS date and GMT date
     *
     * @return void
     */
    private function refreshDate()
    {
        $this->xAmzDate = gmdate( 'Ymd\THis\Z' );
		
        $this->GMTDate  = gmdate( 'Ymd' );
    }
	
	/**
	* Generate sorted and URL-encoded query string from the input parameters
	*
	* @param array $parameters - An associative array of all necessary parameters to submit request the AWS service
	*
	* @return void
	*/
	private function setRequestParameters( $parameters = array() )
	{
		if ( is_array( $parameters ) && 
		     count( $parameters ) )
        {
			ksort( $parameters );
			
			$this->AWSServiceCallQuery = http_build_query( $parameters, '', '&', PHP_QUERY_RFC3986 );
		}
	}
	
	/**
    * Call AWS service and get the response
	*
	* @param array $parameters - An associative array of all necessary parameters to submit request the AWS service
	*
	* @return XML as response
    */
	public function callAWSService( $parameters = array() )
    {
        if ( is_array( $parameters ) && 
		     count( $parameters ) )
        {
            $this->setRequestParameters( $parameters );
			
            $this->refreshDate();
            
            $this->createAWSCallHeaders();
            
			// Request arguments
            $args = array( 'method'      => self::METHOD,
                           'timeout'     => self::TIMEOUT,
                           'redirection' => self::REDIRECTION,
                           'httpversion' => self::HTTPVERSION,
						   'sslverify' 	 => true,
                           'blocking'    => true,
                           'headers'     => $this->AWSServiceCallHeaders,
						   'body'        => NULL,
                           'cookies'     => array()
                         );
			
            // Make the request and fetch response
            $this->AWSServiceResponse = wp_remote_get( $this->AWSServiceEndpoint.'?'.$this->AWSServiceCallQuery, $args );
			
			return $this->AWSServiceResponse;
        }
    }
}
?>
