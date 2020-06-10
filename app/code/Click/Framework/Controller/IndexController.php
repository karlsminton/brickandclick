<?php

namespace Click\Framework\Controller;

use Brick\Http\Response;
use Click\Framework\Model\Layout;

class IndexController
{
    /**
     * @var Response
     */
    public $response;

    /**
     * @var Layout
     */
    private $layoutProcessor;

    /**
     * IndexController constructor.
     */
    public function __construct()
    {
        $this->layoutProcessor = new Layout('');
    }

    /**
     * @return Response
     */
    public function indexAction()
    {
        $response = new Response();
        $content = $this->layoutProcessor->getHtml();
        $response->setContent($content);
        return $response;
    }
}