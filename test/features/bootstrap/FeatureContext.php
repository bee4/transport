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
    private $error;

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
        try {
            $this->response = $this->request->send();
        } catch( \Exception $error ) {
            $this->error = $error;
            if (method_exists($this->error, "getResponse")) {
                $this->response = $error->getResponse();
            }
        }
    }

    /**
     * @Then I should got a status of :status
     */
    public function iShouldGotAStatusOf($status)
    {
        if(null === $this->response) {
            return false;
        }
        return preg_match('/'.$status.'/', $this->response->getStatus())===1;
    }

    /**
     * @Then I should got a status different than :status
     */
    public function iShouldGotAStatusDifferentThan($status)
    {
        if(null === $this->response) {
            return false;
        }
        return preg_match('/'.$status.'/', $this->response->getStatus())!==1;
    }

    /**
     * @Then I should have an empty body
     * @Then I should have a body of :body
     */
    public function iShouldHaveABodyLike($body = '')
    {
        if(null === $this->response) {
            return false;
        }
        return $this->response->getBody()===$body;
    }

    /**
     * @Then I should got an exception :type
     */
    public function iShouldGotAnException($type)
    {
        return $this->error instanceof $type;
    }
}
