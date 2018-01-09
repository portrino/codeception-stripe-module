<?php

namespace Codeception\Module;

use Codeception\Lib\Interfaces\DependsOnModule;
use Codeception\Lib\ModuleContainer;
use Codeception\Module;
use PackageVersions\Versions;

/**
 * Class Stripe
 * @package Codeception\Module
 */
class Stripe extends Module implements DependsOnModule
{

    /**
     * @var string
     */
    protected $dependencyMessage = '"Asserts" module is required.';

    /**
     * @var array
     */
    protected $requiredFields = [
        'api_key',
        'api_version'
    ];

    /**
     * @var array
     */
    protected $config = [
        'api_key' => '',
        'api_version' => '',
        'connected_accounts' => []
    ];

    /**
     * @var string
     */
    protected $apiKey;

    /**
     * @var string
     */
    protected $apiVersion;

    /**
     * Module constructor.
     *
     * Requires module container (to provide access between modules of suite) and config.
     *
     * @param ModuleContainer $moduleContainer
     * @param null|array $config
     * @codeCoverageIgnore
     */
    public function __construct(ModuleContainer $moduleContainer, $config = null)
    {
        parent::__construct($moduleContainer, $config);
    }

    /**
     * @return array
     * @codeCoverageIgnore
     */
    public function _depends()
    {
        return [];
    }

    /**
     * @param array $settings
     * @throws \OutOfBoundsException
     */
    public function _beforeSuite($settings = [])
    {
        $this->config = array_merge($this->config, $settings);
        $this->debug('### Initiliazing Stripe API ###');
        \Stripe\Stripe::setApiKey($this->config['api_key']);
        $this->debugSection('Stripe API Key', \Stripe\Stripe::getApiKey());
        \Stripe\Stripe::setApiVersion($this->config['api_version']);
        $this->debugSection('Stripe API Version', \Stripe\Stripe::getApiVersion());

        \Stripe\Stripe::setAppInfo(
            'portrino/codeception-stripe-module',
            Versions::getVersion('portrino/codeception-stripe-module'),
            'https://github.com/portrino/codeception-stripe-module'
        );
        $this->debugSection('Stripe App Info', \Stripe\Stripe::getAppInfo());
    }

    /**
     * @param string $accountName
     */
    public function amOnConnectedAccount($accountName)
    {
        \Stripe\Stripe::setApiKey($this->config['connected_accounts'][$accountName]['api_key']);
        $this->debugSection('Switched Stripe account', $accountName);
        $this->debugSection('Set Stripe API Key', \Stripe\Stripe::getApiKey());
    }

    /**
     */
    public function amOnDefaultAccount()
    {
        \Stripe\Stripe::setApiKey($this->config['api_key']);
        $this->debugSection('Switched to Stripe default account', '');
        $this->debugSection('Set Stripe API Key', \Stripe\Stripe::getApiKey());
    }

    /**
     * @param array $params
     * @return \Stripe\Customer
     */
    public function haveStripeCustomer($params)
    {
        return \Stripe\Customer::create($params);
    }

    /**
     * @param \Stripe\Customer $customer
     * @return \Stripe\Customer
     */
    public function deleteStripeCustomer(\Stripe\Customer $customer)
    {
        return $customer->delete();
    }

    /**
     * @param \Stripe\Source $source
     *
     * @return \Stripe\Source
     *
     * @throws \Stripe\Error\Api
     * @throws \Stripe\Error\InvalidRequest
     */
    public function detachStripeSource(\Stripe\Source  $source)
    {
        return $source->detach();
    }

    /**
     * @param array $params
     * @return \Stripe\Token
     */
    public function haveStripeToken($params)
    {
        return \Stripe\Token::create($params);
    }

    /**
     * @param array $params
     * @return \Stripe\Source
     */
    public function haveStripeSource($params)
    {
        return \Stripe\Source::create($params);
    }

    /**
     * @param \Stripe\Customer $customer
     * @param \Stripe\Source $source
     * @return \Stripe\Customer
     */
    public function addStripeSourceToStripeCustomer(\Stripe\Customer $customer, \Stripe\Source $source)
    {
        $customer->sources->create(['source' => $source->id]);
        return $customer;
    }

    /**
     * @param string $customerId
     */
    public function seeStripeCustomerWithId($customerId)
    {
        $customer = \Stripe\Customer::retrieve($customerId);
        $this->assertEquals($customerId, $customer->id);
    }

    /**
     * @param string $customerId
     * @return \Stripe\Customer
     */
    public function grabStripeCustomerWithId($customerId)
    {
        return \Stripe\Customer::retrieve($customerId);
    }

    /**
     * @param string $chargeId
     */
    public function seeStripeChargeWithId($chargeId)
    {
        $charge = \Stripe\Charge::retrieve($chargeId);
        $this->assertEquals($chargeId, $charge->id);
    }

    /**
     * @param $chargeId
     * @return \Stripe\Charge
     */
    public function grabStripeChargeWithId($chargeId)
    {
        return \Stripe\Charge::retrieve($chargeId);
    }
}
