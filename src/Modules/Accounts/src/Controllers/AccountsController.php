<?php

namespace Modules\Accounts\Controllers;

use Core\ControllerAbstract;

use Slim\Http\Request;
use Slim\Http\Response;

use Modules\Accounts\Services\AccountsService;

use Exceptions\BadRequestException;
use Exceptions\NotFoundException;
use Exceptions\UnauthorizedException;
use Exceptions\UnexpectedValueException;

use Plugins\Validator\Validate as v;
use Plugins\Paginator\Paginator;

class AccountsController extends ControllerAbstract
{

	private $accountsService;

	public function initialize()
	{
		$this->accountsService = new AccountsService;
	}
	
	public function index(Request $request, Response $response)
	{
		try {

			$allAccounts = $this->accountsService->getAll();

			// var_dump($allAccounts);die;

			$queryParams = $request->getQueryParams();
	        $queryParams = v::validateQueryPaginate($queryParams);

	        $this->_container->logger->info("Ver Todas as Accounts");

	        $paginator = new Paginator($allAccounts);

	        $paginateAccounts = $paginator
                ->search(['name', 'email'], 'like', '%'.$queryParams['search'].'%')
                ->limit($queryParams['limit'])
                ->page($queryParams['page'])
                ->orderBy($queryParams['field'], $queryParams['sort']??'asc')
                ->exec();

	        return
	        $this->_serialize($paginateAccounts);
			
		} catch (UnexpectedValueException $e) {
			return $this->_error($e->getMessage(), $e->getCode(), $e->getTrace());
		} catch (NotFoundException $e) {
			return $this->_error($e->getMessage(), $e->getCode(), $e->getTrace());
		} catch (UnauthorizedException $e) {
			return $this->_error($e->getMessage(), $e->getCode(), $e->getTrace());
		} catch (\Exception $e) {
			return $this->_error($e->getMessage(), $e->getCode(), $e->getTrace());
		}
		
	}

	public function view(Request $request, Response $response, $args)
	{
		try {

			return
			$this->_serialize($this->accountsService->get($args['id']));

		} catch (NotFoundException $e) {
			return $this->_error($e->getMessage(), $e->getCode(), $e->getTrace());
		} catch (\Exception $e) {
			return
			$this->_error($e->getMessage(), $e->getCode(), $e->getTrace());
		}

	}

	public function add(Request $request, Response $response)
	{
		$params = $request->getParsedBody();
		$fields = ['name', 'email', 'password', 'type', 'phone'];
		$fields = array_flip($fields);
		$fields = array_intersect_key($params, $fields);
		// echo "<pre>";print_r($fields);die;

		try {

			$add = $this->accountsService->add($fields);

			if ($add)
				return $this->_serialize($add, "Adicionado com sucesso!");
		
		} catch (UnexpectedValueException $e) {
			return
			$this->_error($e->getMessage(), $e->getCode(), $e->getTrace());
		} catch (\Exception $e) {
			return
			$this->_error($e->getMessage(), (int)$e->getCode(), $e->getTrace());
		}

	}

	public function edit(Request $request, Response $response, $args)
	{
		$params = $request->getParsedBody();
		try {

			$edit = $this->accountsService->edit($args['id'], $params);
		
			if ($edit)
				return $this->_serialize($edit, "Atualizado com sucesso!");

		} catch (NotFoundException $e) {
			return
			$this->_error($e->getMessage(), $e->getCode(), $e->getTrace());
		} catch (\Exception $e) {
			return
			$this->_error($e->getMessage(), $e->getCode(), $e->getTrace());
		}
		
	}

	public function delete(Request $request, Response $response, $args)
	{
		try {
			
			$del = $this->accountsService->del($args['id']);
			
			if ($del)
			return $this->_serialize($del, "Deletado com sucesso!");
		
		} catch (NotFoundException $e) {
			return
			$this->_error($e->getMessage(), $e->getCode(), $e->getTrace());
		} catch (\Exception $e) {
			return
			$this->_error($e->getMessage(), $e->getCode(), $e->getTrace());
		}
	}

}