<?php

require_once("serviceImpl/BaseService.php");

/**
 * Implementacao de @{TransactionService}.
 *
 */
class TransactionServiceImpl extends BaseService implements TransactionService {

	public function __construct() {
		
		parent::__construct();
	}
	
	public function __destruct() {
		
		parent::__destruct();
	}

	public function createTransaction(TransactionRequest $transactionRequest) {
		
		try{

			$httpResponse = $this->getHttpHelper()->post(Config::transactionHost, $transactionRequest, $this->getAuthenticationHelper()->generateAuthenticationOAuth());

			if(!$httpResponse->isResponseOK()){
			
				if($httpResponse->isBadRequest()) {
				
					throw new TransactionException("Parametros fornecidos sao invalidos: " . $httpResponse->getResponse());
				}
			
				throw new TransactionException("Falha ao criar transacao: " . $httpResponse->getResponse());
			}

			return $this->parse($httpResponse->getResponse());
			
		} catch(ServiceHttpException $e) {
			
			throw new TransactionException("Falha HTTP ao criar transacao", $e);
		}
	}
}
?>