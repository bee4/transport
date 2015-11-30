<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

use Bee4\Transport\Client;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context, SnippetAcceptingContext
{
    private $client;

    private $request;
    private $response;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct($rootUrl = "http://localhost")
    {
        $this->client = new Client($rootUrl);
        $this->response = null;
        $this->request  = null;
    }

    /**
     * @Given I make a :method request to :url with :body
     * @Given I make a :method request to :url
     */
    public function iMadeARequestToTheUrl($method, $url, $body = null)
    {
        $this->request = $this->client->createRequest($method, $url);
        if( isset($body) ) {
            $this->request->setBody($body);
        }
        $this->response = $this->request->send();
    }

    /**
     * @Then I should got a status of :status
     */
    public function iShouldGotAStatusOf($status)
    {
        return $this->response->getStatus()==$status;
    }
}
