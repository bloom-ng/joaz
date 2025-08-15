<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class DhlExpressService
{
    protected $client;
    protected $accountNumber;
    protected $username;
    protected $password;
    protected $baseUrl;

    public function __construct()
    {
        $this->baseUrl       = config('services.dhl.base_url');
        $this->accountNumber = config('services.dhl.account_number');
        $this->username      = config('services.dhl.username');
        $this->password      = config('services.dhl.password');

        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'auth'     => [$this->username, $this->password],
            'headers'  => [
                'Accept'       => 'application/json',
                'Content-Type' => 'application/json',
            ]
        ]);
    }

    /**
     * Determine billing currency based on destination
     */
    protected function resolveCurrency(string $countryCode): string
    {
        return strtoupper($countryCode) === 'NG' ? 'NGN' : 'USD';
    }

    /**
     * Get shipping rates
     */
    public function getRates(array $params)
    {
        $params['accountNumber'] = $this->accountNumber;
        $params['unitOfMeasure'] = $params['unitOfMeasure'] ?? 'metric';
        $params['currencyCode']  = $this->resolveCurrency($params['destinationCountryCode']);

        $response = $this->client->get('/rates', ['query' => $params]);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Create shipment
     */
    public function createShipment(array $shipmentData)
    {
        $shipmentData['plannedShippingDateAndTime'] = $shipmentData['plannedShippingDateAndTime'] ?? now()->format('c');
        $shipmentData['customerDetails']['shipperDetails']['accountNumber'] = $this->accountNumber;

        // Set currency
        $shipmentData['shipmentCurrency'] = $this->resolveCurrency(
            $shipmentData['customerDetails']['receiverDetails']['postalAddress']['countryCode']
        );

        $response = $this->client->post('/shipments', ['json' => $shipmentData]);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Track a shipment
     */
    public function trackShipment(string $trackingNumber)
    {
        $response = $this->client->get("/shipments/{$trackingNumber}/tracking");
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Create a pickup booking
     */
    public function createPickup(array $pickupData)
    {
        $pickupData['accountNumber'] = $this->accountNumber;

        $response = $this->client->post('/pickups', ['json' => $pickupData]);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Validate pickup/delivery address capability
     */
    public function validateAddress(array $params)
    {
        $response = $this->client->get('/address-validate', ['query' => $params]);
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Get landed cost (duty, tax, shipping cost)
     */
    public function getLandedCost(array $costData)
    {
        // Ensure currency matches destination
        if (isset($costData['receiverCountryCode'])) {
            $costData['currencyCode'] = $this->resolveCurrency($costData['receiverCountryCode']);
        }

        $response = $this->client->post('/landed-cost', ['json' => $costData]);

        return json_decode($response->getBody()->getContents(), true);
    }
}
