<?php


namespace App\Services;

use Google_Client;
use Google_Service_AnalyticsData;
use Google_Service_AnalyticsData_RunReportRequest;
use Google_Service_AnalyticsData_DateRange;
use Google_Service_AnalyticsData_Dimension;
use Google_Service_AnalyticsData_Metric;

class GoogleAnalyticsService
{
    protected $client;
    protected $analytics;

    public function __construct()
    {
        $this->client = new Google_Client();
        $this->client->setAuthConfig(storage_path('app/analytics/service-account-credentials.json'));
        $this->client->addScope('https://www.googleapis.com/auth/analytics.readonly');
        
        $this->analytics = new Google_Service_AnalyticsData($this->client);
    }

    public function getAnalyticsData($propertyId, $startDate, $endDate)
    {
        // Fetch general analytics data
        $request = new Google_Service_AnalyticsData_RunReportRequest();
        $request->setDateRanges([new Google_Service_AnalyticsData_DateRange(['startDate' => $startDate, 'endDate' => $endDate])]);
        $request->setDimensions([new Google_Service_AnalyticsData_Dimension(['name' => 'pagePath'])]);
        $request->setMetrics([
            new Google_Service_AnalyticsData_Metric(['name' => 'activeUsers']),
            new Google_Service_AnalyticsData_Metric(['name' => 'screenPageViews'])
        ]);

        $response = $this->analytics->properties->runReport("properties/{$propertyId}", $request);

        $rows = $response->getRows();
        $analyticsData = [
            'activeUsers' => 0,
            'screenPageViews' => 0,
            'mostVisitedPage' => '',
            'mostVisitedPageViews' => 0
        ];

        foreach ($rows as $row) {
            $pagePath = $row->getDimensionValues()[0]->getValue();
            $activeUsers = $row->getMetricValues()[0]->getValue();
            $screenPageViews = $row->getMetricValues()[1]->getValue();

            $analyticsData['activeUsers'] += $activeUsers;
            $analyticsData['screenPageViews'] += $screenPageViews;

            // Assuming the most visited page logic is implemented based on screenPageViews
            if ($screenPageViews > $analyticsData['mostVisitedPageViews']) {
                $analyticsData['mostVisitedPage'] = $pagePath;
                $analyticsData['mostVisitedPageViews'] = $screenPageViews;
            }
        }

        return $analyticsData;
    }

    public function getCountryData($propertyId, $startDate, $endDate)
    {
        // Fetch country-specific data
        $countryRequest = new Google_Service_AnalyticsData_RunReportRequest();
        $countryRequest->setDateRanges([new Google_Service_AnalyticsData_DateRange(['startDate' => $startDate, 'endDate' => $endDate])]);
        $countryRequest->setDimensions([new Google_Service_AnalyticsData_Dimension(['name' => 'country'])]);
        $countryRequest->setMetrics([new Google_Service_AnalyticsData_Metric(['name' => 'activeUsers'])]);

        $countryResponse = $this->analytics->properties->runReport("properties/{$propertyId}", $countryRequest);

        $countryRows = $countryResponse->getRows();
        $countryData = [];
        $countries = [];

        foreach ($countryRows as $row) {
            $country = $row->getDimensionValues()[0]->getValue();
            $activeUsers = $row->getMetricValues()[0]->getValue();
            $countries[] = $country;
            $countryData[] = $activeUsers;
        }

        return [
            'countryData' => $countryData,
            'countries' => $countries,
        ];
    }

    public function getAllAnalyticsData($propertyId, $startDate, $endDate)
    {
        $analyticsData = $this->getAnalyticsData($propertyId, $startDate, $endDate);
        $countryData = $this->getCountryData($propertyId, $startDate, $endDate);

        return [
            'analyticsData' => $analyticsData,
            'countryData' => $countryData['countryData'],
            'countries' => $countryData['countries'],
        ];
    }
}